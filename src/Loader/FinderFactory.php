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

use Symfony\Component\Finder\Finder;

/**
 * @author Christin Gruber <c.gruber@touchdesign.de>
 */
class FinderFactory implements FinderFactoryInterface
{
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
