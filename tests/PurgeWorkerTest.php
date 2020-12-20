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

namespace Touchdesign\Logrotate\Tests;

use Touchdesign\Logrotate\Loader\LogfileLoader;
use Touchdesign\Logrotate\Worker\PurgeWorker;

/**
 * @author Christin Gruber <c.gruber@touchdesign.de>
 */
final class PurgeWorkerTest extends AbstractBaseTest
{
    public function testPurge(): void
    {
        $this->assertFileExists($this->filesystem->url().'/logs/foo.log');
        $this->assertStringEqualsFile($this->filesystem->url().'/logs/foo.log', self::CONTENT);

        $rotate = new PurgeWorker(
            (new LogfileLoader($this->filesystem->url().'/logs/foo.log'))
        );
        $rotate->run();

        $this->assertFileNotExists($this->filesystem->url().'/logs/foo.log');
        $this->assertFileExists($this->filesystem->url().'/logs/bar.log');
    }
}
