# Logrotate

## Install

    composer require touchdesign/logrotate

## Usage

    $rotate = new RotateWorker(
        (new LogfileLoader('/tmp/logfile.log'))
    );

    $rotate->run(3);

    $purge = new PurgeWorker(
        (new LogfileLoader('/tmp/logfile.log'))
    );
    
    $purge->run();