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
use Touchdesign\Logrotate\Worker\Exception\InvalidArgumentException;

/**
 * @author Christin Gruber <c.gruber@touchdesign.de>
 */
class RotateWorker implements WorkerInterface
{
    private LogfileLoaderInterface $loader;

    public function __construct(LogfileLoaderInterface $loader)
    {
        $this->loader = $loader;
    }

    public function run(int $keep = 3): bool
    {
        if ($keep < 1) {
            throw new InvalidArgumentException('Keep should be greater than one, to truncate a logfile use taskTruncateLog($logfile).');
        }

        try {
            foreach ($this->loader->all() as $origin) {
                if ($this->loader->version($origin) < $keep) {
                    $this->loader->rotate($origin, $keep);
                } elseif ($this->loader->version($origin) > $keep) {
                    $this->loader->remove();
                }
            }
        } finally {
            $this->loader->truncate();
        }

        return true;
    }
}
