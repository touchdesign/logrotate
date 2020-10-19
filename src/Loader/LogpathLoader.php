<?php

namespace Touchdesign\Logrotate\Loader;

use Symfony\Component\Finder\Finder;

/**
 * @author Christin Gruber
 */
class LogpathLoader extends \SplFileInfo
{
    /**
     * @var Finder
     */
    protected $finder;

    /**
     * @var LogfileLoader
     */
    protected $logfile;

    public function __construct(LogfileLoader $logfile)
    {
        $this->finder = (new Finder())->in($logfile->getPath());
        $this->logfile = $logfile;
    }

    public function find(): Finder
    {
        return $this->finder->files()
            ->sortByName()
            ->reverseSorting();
    }

    public function rotate(int $keep = 3): self
    {
        foreach ($this->find() as $origin) {
            dump($origin);
            if ($this->logfile->isLogfile($origin)) {
                if ($this->logfile->version($origin) < $keep) {
                    $rotated = $this->logfile->rotate($origin, $keep);
                    dump($rotated);
                } elseif ($this->logfile->version($origin) > $keep) {
                    unlink($origin->getPathname());
                }
            }
        }

        $this->logfile->applyTruncate();
        //$this->logfile->applyOctalPermissons();

        return $this;
    }

    public function archive(): self
    {
        return $this;
    }

    public function purge(): self
    {
        return $this;
    }
}