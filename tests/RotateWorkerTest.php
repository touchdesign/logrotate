<?php

declare(strict_types=1);

namespace Touchdesign\Logrotate\Tests;

use Touchdesign\Logrotate\Loader\LogfileLoader;
use Touchdesign\Logrotate\Worker\Exception\InvalidArgumentException;
use Touchdesign\Logrotate\Worker\RotateWorker;

/**
 * @author Christin Gruber
 */
final class RotateWorkerTest extends AbstractBaseTest
{
    public function testRotate(): void
    {
        $this->assertFileExists($this->filesystem->url().'/logs/foo.log');
        $this->assertStringEqualsFile($this->filesystem->url().'/logs/foo.log', self::CONTENT);

        $rotate = new RotateWorker(
            $loader = (new LogfileLoader($this->filesystem->url().'/logs/foo.log'))
        );
        $rotate->run(1);

        $this->assertFileExists($this->filesystem->url().'/logs/foo.log');
        $this->assertFileExists($this->filesystem->url().'/logs/foo.log.1');
        $this->assertStringEqualsFile($this->filesystem->url().'/logs/foo.log', self::BLANK);
        $this->assertStringEqualsFile($this->filesystem->url().'/logs/foo.log.1', self::CONTENT);
        $this->assertStringEqualsFile($this->filesystem->url().'/logs/bar.log', self::CONTENT);

        $rotate->run(1);

        $this->assertEquals(2, \iterator_count($loader->all()));
    }

    public function testInvalidArgumentException(): void
    {
        $this->assertFileExists($this->filesystem->url().'/logs/foo.log');
        $this->expectException(InvalidArgumentException::class);

        $rotate = new RotateWorker(
            $loader = (new LogfileLoader($this->filesystem->url().'/logs/foo.log'))
        );
        $rotate->run(0);
    }
}
