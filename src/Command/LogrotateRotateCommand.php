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
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Touchdesign\Logrotate\Loader\LogfileLoader;
use Touchdesign\Logrotate\Worker\RotateWorker;

/**
 * @author Christin Gruber <c.gruber@touchdesign.de>
 */
class LogrotateRotateCommand extends Command
{
    public const NAME = 'logrotate:rotate';
    public const DESCRIPTION = 'Rotate log files.';
    public const KEEP = 3;

    protected function configure()
    {
        $this
            ->setName(self::NAME)
            ->setDescription(self::DESCRIPTION)
            ->addArgument(
                'logfile',
                InputArgument::REQUIRED,
                'Path to log file.'
            )
            ->addOption(
                'keep',
                'k',
                InputOption::VALUE_OPTIONAL,
                'Number of log files to keep.',
                RotateWorker::KEEP
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $logfile = $input->getArgument('logfile');
        $keep = (int) $input->getOption('keep');

        $worker = new RotateWorker(
            $loader = (new LogfileLoader($logfile))
        );

        $worker->run($keep);

        $io->success(
            sprintf(
                'Log file "%s" successful rotated, keep "%d" versions.',
                $logfile,
                $keep
            )
        );

        return Command::SUCCESS;
    }
}
