<?php

namespace Touchdesign\Logrotate\Loader;

use Symfony\Component\Filesystem\Filesystem;

/**
 * @author Christin Gruber
 */
class LogfileLoader extends \SplFileInfo
{
    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var string
     */
    protected $contents;

    public function __construct($logfile)
    {
        parent::__construct($logfile);
        $this->filesystem = new Filesystem();
    }

    public function getOctalPermissions(): string
    {
        return substr(sprintf('%o', $this->getPerms()), -4);
    }

    public function applyOctalPermissons(int $mode): self
    {
        if (octdec(decoct($mode)) != $mode) {
            throw new \InvalidArgumentException(
                sprintf('Octal permissions should be in octal format like 0600.', $mode)
            );
        }

        $this->filesystem->chmod($this->getPathname(), $mode);

        return $this;
    }

    public function getContents(): string
    {
        return $this->contents = file_get_contents($this->getPathname());
    }

    public function applyTruncate(): self
    {
        $this->filesystem->dumpFile($this->getPathname(), false);

        return $this;
    }

    public function isLogfile(\SplFileInfo $origin): bool
    {
        if (substr($origin->getFilename(), 0, strlen($this->getFilename())) != $this->getFilename()) {
            return false;
        }

        return true;
    }

    public function version(\SplFileInfo $origin): int
    {
        return $origin->getExtension() === $this->getExtension() ? 0
            : $origin->getExtension();
    }

    public function next(\SplFileInfo $origin): int
    {
        return $this->version($origin) + 1;
    }

    public function rotate(\SplFileInfo $origin, int $keep = 3): string
    {
        $rotated = $this->getPathname().'.'.$this->next($origin);
        if ($this->next($origin) === $keep) {
            $this->filesystem->remove($rotated);
        }

        $this->filesystem->rename($origin->getPathname(), $rotated);

        return $rotated;
    }
}