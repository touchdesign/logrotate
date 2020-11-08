<?php

declare(strict_types=1);

/**
 * @author Christin Gruber
 */
require_once __DIR__.'/../vendor/autoload.php';

use Touchdesign\Logrotate\Loader\LogfileLoader;
use Touchdesign\Logrotate\Worker\PurgeWorker;

$worker = new PurgeWorker(
    (new LogfileLoader('/tmp/logfile.log'))
);

$worker->run();
