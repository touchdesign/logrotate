<?php

declare(strict_types=1);

/*
 * This file is a part of logrotate package.
 *
 * Copyright (c) 2021 Christin Gruber <c.gruber@touchdesign.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Touchdesign\Logrotate\Tests;

use Symfony\Component\Console\Command\Command;
use Touchdesign\Logrotate\Command\LogrotatePurgeCommand;

/**
 * @author Christin Gruber <c.gruber@touchdesign.de>
 */
class PurgeCommandTest extends AbstractBaseTest
{
    public function testFailure()
    {
        $this->expectException(\RuntimeException::class);
        $tester = $this->createCommandTester(new LogrotatePurgeCommand());
        $tester->execute(['', '--no-interaction' => true]);

        $this->assertEquals(Command::FAILURE, $tester->getStatusCode(), 'Returns 1 in case of success');
    }

    public function testSuccess()
    {
        $tester = $this->createCommandTester(new LogrotatePurgeCommand());
        $tester->execute(['logfile' => $this->filesystem->url().'/logs/foo.log', '--no-interaction' => true], ['--no-interaction']);

        $this->assertEquals(Command::SUCCESS, $tester->getStatusCode(), 'Returns 0 in case of success');
    }
}
