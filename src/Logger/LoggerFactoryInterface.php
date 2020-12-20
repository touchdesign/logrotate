<?php

declare(strict_types=1);

/*
 * This file is a part of logrotate package.
 *
 * Copyright (c) 2020 Christin Gruber <c.gruber@touchdesign.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Touchdesign\Logrotate\Logger;

use Monolog\Handler\HandlerInterface;
use Monolog\Logger;

/**
 * @author Christin Gruber <c.gruber@touchdesign.de>
 */
interface LoggerFactoryInterface
{
    public function __construct(array $handler = []);

    public function addHandler(HandlerInterface $handler): self;

    public function create(string $name = 'logrotate'): Logger;
}
