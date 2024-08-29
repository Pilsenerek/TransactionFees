<?php
declare(strict_types=1);

namespace App\Service;

use App\Model\Transaction;

class CalculateFees
{
    private const BASE_CURRENCY = 'EUR';
    private const UE_FEE_RATE = 0.01;
    private const NO_UE_FEE_RATE = 0.02;

    public function __construct(
        private CurrencyRateProvider $currencyRateProvider,
        private GeoHelper            $geoHelper
    )
    {
    }

    public function calculate(Transaction $transaction): Transaction
    {
        $isEu = $this->geoHelper->isEu($transaction->getBin());
        $rate = $this->currencyRateProvider->retrieveRate($transaction->getCurrency());
        $base = $transaction->getAmount();
        if (!empty($rate) && $transaction->getCurrency() !== self::BASE_CURRENCY) {
            $base = $base / $rate;
        }
        $commRate = self::NO_UE_FEE_RATE;
        if ($isEu) {
            $commRate = self::UE_FEE_RATE;
        }
        $commission = (int)ceil($commRate * $base);
        $transaction->setCommission($commission);

        return $transaction;
    }
}
