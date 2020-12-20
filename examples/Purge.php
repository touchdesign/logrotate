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

require_once __DIR__.'/../vendor/autoload.php';

use Touchdesign\Logrotate\Loader\LogfileLoader;
use Touchdesign\Logrotate\Worker\PurgeWorker;

$worker = new PurgeWorker(
    (new LogfileLoader('/tmp/logfile.log'))
);

$worker->run();
