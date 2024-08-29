<?php
declare(strict_types=1);

namespace App\Service;

use App\Model\Transaction;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class TransactionFileProvider
{
    public function __construct(private DenormalizerInterface $denormalizer)
    {
    }

    /**
     * @return \Generator|Transaction[]
     * @throws \Exception
     * @throws ExceptionInterface
     */
    public function fetchTransactions(string $filePath): \Generator
    {
        $fileHandle = \fopen(__DIR__ . '/../../' . $filePath, 'r');
        $count = 0;
        while (!\feof($fileHandle)) {
            $line = \fgets($fileHandle);

            yield $this->createTransaction($line, ++$count);
        }
        \fclose($fileHandle);
    }

    /**
     * @throws ExceptionInterface
     * @throws \Exception
     */
    private function createTransaction(string $line, int $count): Transaction
    {
        $transactionArray = \json_decode($line, true);
        if (empty($transactionArray)) {
            throw new \Exception(sprintf('File parsing error in line %s', $count));
        }
        $transactionArray['amount'] = (int)$transactionArray['amount'] * 100;
        $transaction = $this->denormalizer->denormalize($transactionArray, Transaction::class);

        return $transaction;
    }
}
