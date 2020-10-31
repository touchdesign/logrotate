<?php

declare(strict_types=1);

namespace Touchdesign\Logrotate\Worker;

use Touchdesign\Logrotate\Loader\LogfileLoaderInterface;

/**
 * @author Christin Gruber
 */
class RotateWorker implements WorkerInterface
{
    /**
     * @var LogfileLoaderInterface
     */
    private $loader;

    public function __construct(LogfileLoaderInterface $loader)
    {
        $this->loader = $loader;
    }

    public function run(int $keep = 3): bool
    {
        try {
            foreach ($this->loader->all() as $origin) {
                if ($this->loader->version($origin) < $keep) {
                    $this->loader->rotate($origin, $keep);
                } elseif ($this->loader->version($origin) > $keep) {
                    $this->loader->remove();
                }
            }
        } finally {
            $this->loader->truncate();
        }

        return true;
    }
}
