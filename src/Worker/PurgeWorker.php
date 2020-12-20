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

namespace Touchdesign\Logrotate\Worker;

use Touchdesign\Logrotate\Loader\LogfileLoaderInterface;

/**
 * @author Christin Gruber <c.gruber@touchdesign.de>
 */
class PurgeWorker implements WorkerInterface
{
    private LogfileLoaderInterface $loader;

    public function __construct(LogfileLoaderInterface $loader)
    {
        $this->loader = $loader;
    }

    public function run(): bool
    {
        foreach ($this->loader->all() as $origin) {
            $this->loader->remove(
                $this->loader->version($origin)
            );
        }

        return true;
    }
}
