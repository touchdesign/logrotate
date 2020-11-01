<?php

declare(strict_types=1);

namespace Touchdesign\Logrotate\Loader;

use Symfony\Component\Finder\Finder;

/**
 * @author Christin Gruber
 */
class FinderFactory implements FinderFactoryInterface
{
    /**
     * @var LogfileLoaderInterface
     */
    private LogfileLoaderInterface $loader;

    public function __construct(LogfileLoaderInterface $loader)
    {
        $this->loader = $loader;
    }

    public function create(): Finder
    {
        return (new Finder())->in($this->loader->getPath())
            ->depth(0)
            ->files()
            ->filter(
                function (\SplFileInfo $current) {
                    return substr($current->getFilename(), 0, \strlen($this->loader->getFilename()))
                        == $this->loader->getFilename();
                }
            )
            ->sortByName()
            ->reverseSorting();
    }
}
