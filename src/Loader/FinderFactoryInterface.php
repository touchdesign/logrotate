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
interface FinderFactoryInterface
{
    public function __construct(LogfileLoaderInterface $loader);

    public function create(): Finder;
}
