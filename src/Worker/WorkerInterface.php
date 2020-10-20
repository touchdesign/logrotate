<?php

declare(strict_types=1);

namespace Touchdesign\Logrotate\Worker;

/**
 * @author Christin Gruber
 */
interface WorkerInterface
{
    public function run(): bool;
}
