<?php

declare(strict_types=1);

namespace Touchdesign\Logrotate\Loader;

use Symfony\Component\Finder\Finder;

/**
 * @author Christin Gruber
 */
interface FinderFactoryInterface
{
    public function __construct(LogfileLoaderInterface $loader);

    public function create(): Finder;
}
