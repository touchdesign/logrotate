<?php

declare(strict_types=1);

/**
 * @author Christin Gruber
 */
require_once '../vendor/autoload.php';

use Touchdesign\Logrotate\Loader\LogfileLoader;
use Touchdesign\Logrotate\Worker\RotateWorker;

$worker = new RotateWorker(
    $loader = (new LogfileLoader('/tmp/logfile.log'))
);

$worker->run(3);
