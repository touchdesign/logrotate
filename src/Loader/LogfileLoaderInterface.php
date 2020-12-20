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

/**
 * @author Christin Gruber <c.gruber@touchdesign.de>
 */
interface LogfileLoaderInterface
{
    public function __construct(string $logfile, int $mode);

    public function all(): ?\Iterator;

    public function truncate(): self;

    public function remove(?int $version = null): self;

    public function rotate(\SplFileInfo $origin, int $keep = 3): string;
}
