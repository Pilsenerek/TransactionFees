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

    /**
     * @return string
     */
    public function getBin(): string
    {
        return $this->bin;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @return float|null
     */
    public function printAmount(): ?string
    {
        return number_format($this->amount / 100, 2, '.', ' ');
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @return int|null
     */
    public function getCommission(): ?int
    {
        return $this->commission;
    }

    /**
     * @return float|null
     */
    public function printCommission(): ?string
    {
        return number_format($this->commission / 100, 2, '.', ' ');
    }

    /**
     * @param int|null $commission
     */
    public function setCommission(?int $commission): void
    {
        $this->commission = $commission;
    }

    public function __toString()
    {
        return sprintf('  %s  %s  %s  %s', $this->printAmount(), $this->currency, $this->bin, $this->printCommission());
    }
}
