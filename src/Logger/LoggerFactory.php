<?php

declare(strict_types=1);

namespace Touchdesign\Logrotate\Logger;

use Monolog\Handler\HandlerInterface;
use Monolog\Logger;
use Touchdesign\Logrotate\Logger\Exception\InvalidArgumentException;

/**
 * @author Christin Gruber
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
            throw new InvalidArgumentException(
                sprintf('Invalid LoggerHandler passed, Handler must implement HandlerInterface.')
            );
        }

        array_push($this->handlers, $handler);

        return $this;
    }

    public function create(string $name = 'logrotate'): Logger
    {
        return (new Logger($name))
            ->setHandlers($this->handlers);
    }
}
