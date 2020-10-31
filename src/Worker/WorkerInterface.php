<?php

declare(strict_types=1);

namespace Touchdesign\Logrotate\Worker;

use Touchdesign\Logrotate\Loader\LogfileLoaderInterface;

/**
 * @author Christin Gruber
 */
interface WorkerInterface
{
    public function __construct(LogfileLoaderInterface $loader);

    public function run(): bool;
}
