<?php

declare(strict_types=1);

/*
 * This file is a part of logrotate package.
 *
 * Copyright (c) 2021 Christin Gruber <c.gruber@touchdesign.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Touchdesign\Logrotate\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Touchdesign\Logrotate\Loader\LogfileLoader;
use Touchdesign\Logrotate\Worker\PurgeWorker;

/**
 * @author Christin Gruber <c.gruber@touchdesign.de>
 */
class LogrotatePurgeCommand extends Command
{
    public const NAME = 'logrotate:purge';
    public const DESCRIPTION = 'Purge log files.';

    protected function configure()
    {
        $this
            ->setName(self::NAME)
            ->setDescription(self::DESCRIPTION)
            ->addArgument(
                'logfile',
                InputArgument::REQUIRED,
                'Path to log file.'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $logfile = $input->getArgument('logfile');

        $worker = new PurgeWorker(
            $loader = (new LogfileLoader($logfile))
        );

        if ($count = $loader->all()->count()) {
            if (!$io->confirm(
                sprintf(
                    'Sure you will purge "%d" log files for "%s"?',
                    $count,
                    $logfile
                ),
                false
            )) {
                return Command::FAILURE;
            }
        }

        $worker->run();

        $io->success(
            sprintf(
                'Successful purged log files for "%s".',
                $logfile
            )
        );

        return Command::SUCCESS;
    }
}
