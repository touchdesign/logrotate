<?php

declare(strict_types=1);

namespace Touchdesign\Logrotate\Worker;

use Touchdesign\Logrotate\Loader\LogfileLoaderInterface;
use Touchdesign\Logrotate\Worker\Exception\InvalidArgumentException;

/**
 * @author Christin Gruber
 */
class RotateWorker implements WorkerInterface
{
    /**
     * @var LogfileLoaderInterface
     */
    private LogfileLoaderInterface $loader;

    public function __construct(LogfileLoaderInterface $loader)
    {
        $this->loader = $loader;
    }

    public function run(int $keep = 3): bool
    {
        if ($keep < 1) {
            throw new InvalidArgumentException(
                'Keep should be greater than one, to truncate a logfile use taskTruncateLog($logfile).'
            );
        }

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
