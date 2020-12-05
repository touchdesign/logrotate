<?php

declare(strict_types=1);

namespace Touchdesign\Logrotate\Loader;

/**
 * @author Christin Gruber
 */
interface LogfileLoaderInterface
{
    public function __construct(string $logfile, int $mode);

    public function all(): ?\Iterator;

    public function truncate(): self;

    public function remove(?int $version = null): self;

    public function rotate(\SplFileInfo $origin, int $keep = 3): string;
}
