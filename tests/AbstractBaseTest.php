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

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @author Christin Gruber <c.gruber@touchdesign.de>
 */
abstract class AbstractBaseTest extends TestCase
{
    const CONTENT = 'HelloContent';
    const BLANK = '';

    /**
     * @vfsStream virtual file system
     */
    protected vfsStreamDirectory $filesystem;

    protected function setUp(): void
    {
        $this->filesystem = vfsStream::setup('root', 0644, [
            'logs' => [
                'foo.log' => self::CONTENT,
                'bar.log' => self::CONTENT,
            ],
        ]);
    }

    protected function createCommandTester(Command $command): CommandTester
    {
        $application = new Application();
        $application->add($command);

        return new CommandTester(
            $application->find($command::NAME)
        );
    }
}
