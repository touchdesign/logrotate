<?php

declare(strict_types=1);

/**
 * @author Christin Gruber
 */
require_once '../vendor/autoload.php';

use Touchdesign\Logrotate\Loader\LogfileLoader;
use Touchdesign\Logrotate\Worker\PurgeWorker;

$purge = new PurgeWorker(
    (new LogfileLoader('/tmp/logfile.log'))
);

$purge->run();
