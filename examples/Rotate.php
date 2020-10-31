<?php

/**
 * @author Christin Gruber
 */
require_once '../vendor/autoload.php';

use Touchdesign\Logrotate\Loader\LogfileLoader;
use Touchdesign\Logrotate\Worker\RotateWorker;

$rotate = new RotateWorker(
    (new LogfileLoader('/tmp/logfile.log'))
);

$rotate->run(3);
