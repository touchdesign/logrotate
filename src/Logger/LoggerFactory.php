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
use Touchdesign\Logrotate\Logger\Exception\InvalidArgumentException;

/**
 * @author Christin Gruber <c.gruber@touchdesign.de>
 */
class LoggerFactory implements LoggerFactoryInterface
{
    /**
     * @var HandlerInterface[]
     */
    private array $handlers = [];

    public function __construct(array $handlers = [])
    {
        foreach ($handlers as $handler) {
            $this->addHandler($handler);
        }
    }

    public function addHandler(HandlerInterface $handler): LoggerFactoryInterface
    {
        if (!$handler instanceof HandlerInterface) {
            throw new InvalidArgumentException('Invalid LoggerHandler passed, Handler must implement HandlerInterface.');
        }

        $this->handlers[] = $handler;

        return $this;
    }

    public function create(string $name = 'logrotate'): Logger
    {
        return (new Logger($name))
            ->setHandlers($this->handlers);
    }
}
