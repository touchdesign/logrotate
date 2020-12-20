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

namespace Touchdesign\Logrotate\Logger\Traits;

use Psr\Log\LoggerInterface;
use Touchdesign\Logrotate\Logger\LoggerFactory;

/**
 * @author Christin Gruber <c.gruber@touchdesign.de>
 */
trait LoggableTrait
{
    protected LoggerInterface $logger;

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
