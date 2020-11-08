<?php

declare(strict_types=1);

namespace Touchdesign\Logrotate\Logger;

use Monolog\Logger;

/**
 * @author Christin Gruber
 */
interface LoggerFactoryInterface
{
    public function __construct(array $handler = []);

    public function create(string $name = 'logrotate'): Logger;
}
