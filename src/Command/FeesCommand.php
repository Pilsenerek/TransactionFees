<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:fees',
    description: 'Run to calculate fees for transactions from file /input.txt',
)]
class FeesCommand extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('inputFile', InputArgument::REQUIRED, 'File with transactions')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $inputFile = $input->getArgument('inputFile');

        //@todo implement calculation core
        $data = range(1,5);

        $io->table(['Amount', 'Currency', 'Bin', 'Commission'], []);
        foreach ($data as $rec) {
            $io->table([], [
                    [100.34, 'CHF', '2345', 2.34],
                ]
            );
        }

        $io->success(sprintf('Calculating commissions for %s file is finished', $inputFile));

        return Command::SUCCESS;
    }
}
