<?php
declare(strict_types=1);

namespace App\Command;

use App\Service\CalculateFees;
use App\Service\TransactionProvider;
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
    public function __construct(
        private TransactionProvider $transactionProvider,
        private CalculateFees       $calculateFees
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('inputFile', InputArgument::REQUIRED, 'File with transactions');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $inputFile = $input->getArgument('inputFile');
        $io->title(sprintf('Calculating commissions for %s file is started', $inputFile));
        $transactions = $this->transactionProvider->fetchTransactions($inputFile);
        $io->table(['Amount', 'Currency', 'BIN', 'Commission'], []);
        foreach ($transactions as $transaction) {
            $this->calculateFees->calculate($transaction);
            $io->writeln((string)$transaction);
        }
        $io->success('Done!');

        return Command::SUCCESS;
    }
}
