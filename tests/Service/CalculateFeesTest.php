<?php

namespace App\Tests\Service;

use App\Service\CalculateFees;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class CalculateFeesTest extends TestCase
{
    public static function provideData(): array
    {
        return [
            ['23456', 100, 'GBP', 123],
            ['45678', 105, 'GBP', 123],
        ];
    }

    #[DataProvider('provideData')]
    public function testCalculate(string $bin, int $amount, string $currency, int $commission): void
    {
        $calculateFees = new CalculateFees();
        $calcCommission = $calculateFees->calculate($bin, $amount, $currency);
        $this->assertEquals($commission, $calcCommission);
    }
}
