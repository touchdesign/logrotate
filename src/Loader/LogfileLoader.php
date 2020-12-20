<?php

declare(strict_types=1);

/*
 * This file is a part of logrotate package.
 *
 * Copyright (c) 2020 Christin Gruber <c.gruber@touchdesign.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Touchdesign\Logrotate\Loader;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Touchdesign\Logrotate\Loader\Exception\LoaderException;
use Touchdesign\Logrotate\Logger\Traits\LoggableTrait;

/**
 * @author Christin Gruber <c.gruber@touchdesign.de>
 */
class LogfileLoader extends \SplFileInfo implements LogfileLoaderInterface
{
    use LoggableTrait {
        LoggableTrait::__construct as protected __loggable;
    }

    protected Filesystem $filesystem;

    protected Finder $finder;

    /**
     * @var int|null Octal file mode
     */
    private ?int $mode;

    public function __construct(string $origin, int $mode = null)
    {
        $this->filesystem = new Filesystem();
        try {
            $this->mode = $mode;
            parent::__construct($origin);
            $this->__loggable();
            if (!$this->isFile()) {
                $this->truncate();
            }
            $this->finder = (new FinderFactory($this))
                ->create();
        } catch (\Exception $exception) {
            throw new LoaderException(sprintf('Failed to create origin "%s" log file, maybe a permission issue.', $this->getPathname()));
        }
    }

    public function all(): ?\Iterator
    {
        return $this->finder->getIterator() ?? null;
    }

    public function truncate(): LogfileLoaderInterface
    {
        $this->logger->debug('Truncate log '.$this->getPathname());

        $this->filesystem->dumpFile($this->getPathname(), false);
        if ($this->mode) {
            $this->filesystem->chmod($this->getPathname(), $this->mode);
        }

        return $this;
    }

    public function remove(?int $version = null): LogfileLoaderInterface
    {
        $remove = $version
            ? sprintf('%s.%d', $this->getPathname(), $version)
            : $this->getPathname();

        $this->logger->debug('Remove log '.$remove);

        $this->filesystem->remove($remove);

        return $this;
    }

    public function version(\SplFileInfo $origin): int
    {
        return $origin->getExtension() === $this->getExtension() ? 0
            : (int) $origin->getExtension();
    }

    public function next(\SplFileInfo $origin): int
    {
        return $this->version($origin) + 1;
    }

    public function rotate(\SplFileInfo $origin, int $keep = 3): string
    {
        $this->logger->info('Rotate log '.$origin);

        $rotated = $this->getPathname().'.'.$this->next($origin);
        if ($this->next($origin) === $keep) {
            $this->remove($this->next($origin));
        }

        if ($this->mode) {
            $this->filesystem->chmod($this->getPathname(), $this->mode);
        }

        $this->filesystem->rename($origin->getPathname(), $rotated);

        return $rotated;
    }
}
