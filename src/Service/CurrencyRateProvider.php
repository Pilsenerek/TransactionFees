<?php
declare(strict_types=1);

namespace App\Service;

interface CurrencyRateProvider
{

    public function retrieveRate(string $currency): float;
}
