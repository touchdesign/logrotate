<?php

namespace Touchdesign\Logrotate\Loader;

use Symfony\Component\Finder\Finder;

/**
 * @author Christin Gruber
 */
interface LogfileLoaderInterface
{
    public function __construct(string $logfile);

    public function find(): Finder;
}