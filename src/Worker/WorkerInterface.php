<?php

namespace Touchdesign\Logrotate\Worker;

/**
 * @author Christin Gruber
 */
interface WorkerInterface
{
    public function run(): bool;
}