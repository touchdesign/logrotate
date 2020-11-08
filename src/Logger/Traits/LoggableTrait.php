<?php

declare(strict_types=1);

namespace Touchdesign\Logrotate\Logger\Traits;

use Psr\Log\LoggerInterface;
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

    public function setLogger(LoggerInterface $logger): self
    {
        $this->logger = $logger;

        return $this;
    }
}
