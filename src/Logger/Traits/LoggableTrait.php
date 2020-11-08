<?php

declare(strict_types=1);

namespace Touchdesign\Logrotate\Logger\Traits;

use Monolog\Logger;
use Touchdesign\Logrotate\Logger\LoggerFactory;

/**
 * @author Christin Gruber
 */
trait LoggableTrait
{
    protected $logger;

    public function __construct()
    {
        $this->logger = (new LoggerFactory())
            ->create();
    }

    public function setLogger(Logger $logger): self
    {
        $this->logger = $logger;

        return $this;
    }
}
