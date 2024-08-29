<?php
declare(strict_types=1);

namespace App\Model;

class Transaction implements \Stringable
{
    public function __construct(
        private      readonly string $bin,
        private      readonly int $amount,
        private      readonly string $currency,
        private ?int $commission = null
    )
    {
    }

    public function getBin(): string
    {
        return $this->bin;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function printAmount(): ?string
    {
        return \number_format($this->amount / 100, 2, '.', ' ');
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getCommission(): ?int
    {
        return $this->commission;
    }

    public function printCommission(): ?string
    {
        return \number_format($this->commission / 100, 2, '.', ' ');
    }

    public function setCommission(?int $commission): void
    {
        $this->commission = $commission;
    }

    public function __toString()
    {
        return sprintf('  %s  %s  %s  %s', $this->printAmount(), $this->currency, $this->bin, $this->printCommission());
    }
}
