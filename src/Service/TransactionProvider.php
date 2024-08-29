<?php
declare(strict_types=1);

namespace App\Service;

use App\Model\Transaction;

interface TransactionProvider {

    /**
     * @return \Generator|Transaction[]
     */
    public function fetchTransactions(string $filePath):\Generator;
}
