<?php

declare(strict_types=1);

namespace Touchdesign\Logrotate\Worker;

use Touchdesign\Logrotate\Loader\LogfileLoaderInterface;

/**
 * @author Christin Gruber
 */
class PurgeWorker implements WorkerInterface
{
    /**
     * @var LogfileLoaderInterface
     */
    private $loader;

    public function __construct(LogfileLoaderInterface $loader)
    {
        $this->loader = $loader;
    }

    public function run(): bool
    {
        foreach ($this->loader->find() as $origin) {
            $this->loader->remove(
                $this->loader->version($origin)
            );
        }

        return true;
    }
}
