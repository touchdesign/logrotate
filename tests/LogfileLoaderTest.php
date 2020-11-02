<?php

declare(strict_types=1);

namespace Touchdesign\Logrotate\Tests;

use Touchdesign\Logrotate\Loader\LogfileLoader;

/**
 * @author Christin Gruber
 */
final class LogfileLoaderTest extends AbstractBaseTest
{
    public function testSingle(): void
    {
        $this->assertStringEqualsFile($this->filesystem->url().'/logs/foo.log', self::CONTENT);

        (new LogfileLoader($this->filesystem->url().'/logs/foo.log'))
            ->truncate();

        $this->assertFileExists($this->filesystem->url().'/logs/foo.log');
        $this->assertStringEqualsFile($this->filesystem->url().'/logs/foo.log', self::BLANK);
    }

    public function testMode(): void
    {
        $this->assertStringEqualsFile($this->filesystem->url().'/logs/foo.log', self::CONTENT);

        (new LogfileLoader($this->filesystem->url().'/logs/foo.log', 0777))
            ->truncate();

        $this->assertFileExists($this->filesystem->url().'/logs/foo.log');
        $this->assertStringEqualsFile($this->filesystem->url().'/logs/foo.log', self::BLANK);

        $mode = substr(sprintf('%o', fileperms($this->filesystem->url().'/logs/foo.log')), -4);
        $this->assertSame($mode, '0777');
        $this->assertEquals($mode, '0777');
    }

    public function testTruncateOrCreate(): void
    {
        $this->assertFileNotExists($this->filesystem->url().'/logs/bullshit.log');

        (new LogfileLoader($this->filesystem->url().'/logs/bullshit.log'))
            ->truncate();

        $this->assertFileExists($this->filesystem->url().'/logs/bullshit.log');
        $this->assertStringEqualsFile($this->filesystem->url().'/logs/bullshit.log', self::BLANK);
    }

    public function testTypeErrorException(): void
    {
        $this->assertStringEqualsFile(
            $this->filesystem->url().'/logs/foo.log',
            self::CONTENT
        );
        $this->expectException(\TypeError::class);

        (new LogfileLoader($this->filesystem->url().'/logs/foo.log', '-rw-rw-r--'));
        (new LogfileLoader(90210, 0640));
    }
}
