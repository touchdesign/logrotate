[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.4-8892BF.svg)](https://php.net/)

# Logrotate

Linux like log rotate component written in PHP. For example, if you have a 
simple `logfile.log` you can rotate (move) it to `logfile.log.1` and so on. 
The source logfile will be truncated. The number of logfiles to keep can 
controlled with the `$keep` option.

## Dependencies

 * PHP 7.4 or higher

## Install

```shell
composer require touchdesign/logrotate
```

## Usage

```php
$rotate = new RotateWorker(
    (new LogfileLoader('/tmp/logfile.log'))
);

// Note: Keep 3 logfiles archived
$rotate->run(3);

$purge = new PurgeWorker(
    (new LogfileLoader('/tmp/logfile.log'))
);

$purge->run();
```

For more examples take a look at the example folder in this repository.

## Symfony console tasks

For a symfony console task integration see our [logrotate-bundle](https://github.com/touchdesign/logrotate-bundle)