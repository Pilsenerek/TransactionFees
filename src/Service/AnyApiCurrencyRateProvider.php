<?php
declare(strict_types=1);

namespace App\Service;

class AnyApiCurrencyRateProvider implements CurrencyRateProvider
{
    private const API_URL = 'https://anyapi.io/api/v1/exchange/rates?base=EUR&apiKey=vbt7643ggtgq0mga5o54qmo4kaeds9j1qtmlk9u6ebqhkrj12fjo';

    private array $rateData = [];

    /**
     * @throws \Exception
     */
    public function retrieveRate(string $currency): float
    {
        if (empty($this->rateData)) {
            $rateArray = \json_decode(\file_get_contents(self::API_URL), true);
            if (empty($rateArray['rates'][$currency])) {
                throw new \Exception(\sprintf('Impossible to retrieve data from URL: %s', self::API_URL));
            }
            $this->rateData = $rateArray;
        }

        return (float)$this->rateData['rates'][$currency];
    }
}
