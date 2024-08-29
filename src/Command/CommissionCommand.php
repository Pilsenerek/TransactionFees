<?php
declare(strict_types=1);

namespace App\Command;

use App\Service\CalculateFees;
use App\Service\TransactionFileProvider;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

#[AsCommand(
    name: 'app:commission',
    description: 'Run to calculate commissions for transactions from file /input.txt',
)]
class CommissionCommand extends Command
{
    public function __construct(
        private TransactionFileProvider $transactionProvider,
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

    /**
     * @throws ExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $inputFile = $input->getArgument('inputFile');
        $io->title(\sprintf('Calculating commissions for %s file is started', $inputFile));
        $transactions = $this->transactionProvider->fetchTransactions($inputFile);
        $io->table(['Amount', 'Currency', 'BIN', 'Commission'], []);
        foreach ($transactions as $transaction) {
            $this->calculateFees->calculate($transaction);
            //@todo try to add progress info, example: https://symfony.com/doc/current/components/console/helpers/progressbar.html
            $io->writeln((string)$transaction);
        }
        $io->success('Done! See result above.');

        return Command::SUCCESS;
    }
}
