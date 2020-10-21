<?php

declare(strict_types=1);

namespace Touchdesign\Logrotate\Loader;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Touchdesign\Logrotate\Loader\Exception\InvalidArgumentException;
use Touchdesign\Logrotate\Loader\Exception\LoaderException;

/**
 * @author Christin Gruber
 */
class LogfileLoader extends \SplFileInfo implements LogfileLoaderInterface
{
    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var Finder
     */
    protected $finder;

    /**
     * @var string
     */
    protected $contents;

    public function __construct(string $origin)
    {
        $this->filesystem = new Filesystem();
        try {
            parent::__construct($origin);
            if (!$this->isFile()) {
                $this->truncate();
            }
        } catch (\Exception $exception) {
            throw new LoaderException(
                sprintf('Failed to create origin "%s" log file, maybe a permission issue.', $this->getPathname())
            );
        }
    }

    public function find(): Finder
    {
        $this->finder = (new Finder())->in($this->getPath());

        return $this->finder->files()
            ->filter(
                function (\SplFileInfo $origin) {
                    return substr($origin->getFilename(), 0, \strlen($this->getFilename())) == $this->getFilename();
                }
            )
            ->sortByName()
            ->reverseSorting();
    }

    public function permissions(int $mode): self
    {
        if (octdec(decoct($mode)) != $mode) {
            throw new InvalidArgumentException(
                sprintf('Permissions "%s" should be in octal format like 0600.', $mode)
            );
        }

        $this->filesystem->chmod($this->getPathname(), $mode);

        return $this;
    }

    public function truncate(): self
    {
        $this->filesystem->dumpFile($this->getPathname(), false);

        return $this;
    }

    public function remove(?int $version): self
    {
        $remove = $version
            ? sprintf('%s.%d', $this->getPathname(), $version)
            : $this->getPathname();

        $this->filesystem->remove($remove);

        return $this;
    }

    public function isLogfile(\SplFileInfo $origin): bool
    {
        if (substr($origin->getFilename(), 0, \strlen($this->getFilename())) != $this->getFilename()) {
            return false;
        }

        return true;
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
        $rotated = $this->getPathname().'.'.$this->next($origin);
        if ($this->next($origin) === $keep) {
            $this->remove($this->next($origin));
        }

        $this->filesystem->rename($origin->getPathname(), $rotated);

        return $rotated;
    }
}
