<?php

declare(strict_types=1);

namespace Touchdesign\Logrotate\Tests;

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use PHPUnit\Framework\TestCase;

/**
 * @author Christin Gruber
 */
abstract class AbstractBaseTest extends TestCase
{
    const CONTENT = 'HelloContent';
    const BLANK = '';

    /**
     * @vfsStream virtual file system
     */
    protected vfsStreamDirectory $filesystem;

    public function setUp(): void
    {
        $this->filesystem = vfsStream::setup('root', 0644, [
            'logs' => [
                'foo.log' => self::CONTENT,
                'bar.log' => self::CONTENT,
            ],
        ]);
    }
}
