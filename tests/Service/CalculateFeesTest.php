<?php
declare(strict_types=1);

namespace App\Tests\Service;

use App\Model\Transaction;
use App\Service\CalculateFees;
use App\Service\CurrencyRateProvider;
use App\Service\GeoHelper;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class CalculateFeesTest extends TestCase
{
    /**
     * @var array|string[] BIN code => is EU
     */
    private array $mockGeoHelperResponses = [
        ['45717360', true],
        ['516793', true],
        ['45417360', true],
        ['41417360', true],
        ['4745030', true],
        ['1234567', false],
    ];

    /**
     * @var array|string[] Currency code => rate
     */
    private array $mockCurrencyRateResponses = [
        ['EUR', 1],
        ['USD', 1.1088],
        ['JPY', 160.36],
        ['GBP', 0.84175],
    ];

    /**
     * @return array[] BIN code, amount, currency code, expected commission
     */
    public static function provideData(): array
    {
        return [
            ['45717360', 100.00, 'EUR', 1],
            ['516793', 50.00, 'USD', 0.46],
            ['45417360', 10000.00, 'JPY', 0.63],
            ['41417360', 130.00, 'USD', 1.18],
            ['4745030', 2000.00, 'GBP', 23.77],
            ['1234567', 1000.00, 'EUR', 20.00],
        ];
    }

    /**
     * @throws Exception
     */
    #[DataProvider('provideData')]
    public function testCalculate(string $bin, float $amount, string $currency, float $expCommission): void
    {
        $geoHelper = $this->createStub(GeoHelper::class);
        $geoHelper->method('isEU')->willReturnMap($this->mockGeoHelperResponses);
        $currencyRateProvider = $this->createStub(CurrencyRateProvider::class);
        $currencyRateProvider->method('retrieveRate')->willReturnMap($this->mockCurrencyRateResponses);
        $calculateFees = new CalculateFees($currencyRateProvider, $geoHelper);
        $transaction = new Transaction($bin, $amount * 100, $currency);
        $calculateFees->calculate($transaction);

        $this->assertEquals($expCommission * 100, $transaction->getCommission());
    }
}
