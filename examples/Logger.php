<?php

declare(strict_types=1);

/**
 * @author Christin Gruber
 */
require_once __DIR__.'/../vendor/autoload.php';

use Monolog\Handler\StreamHandler;
use Touchdesign\Logrotate\Loader\LogfileLoader;
use Touchdesign\Logrotate\Logger\LoggerFactory;
use Touchdesign\Logrotate\Worker\RotateWorker;

$worker = new RotateWorker(
    $loader = (new LogfileLoader('/tmp/logfile.log'))
);

// pass multiple handlers at once
$loader->setLogger(
    (new LoggerFactory([new StreamHandler('php://stdout')]))
        ->create()
);

// or one by one
$loader->setLogger(
    (new LoggerFactory())
        ->addHandler(new StreamHandler('php://stdout'))
        ->create()
);

$worker->run(3);
