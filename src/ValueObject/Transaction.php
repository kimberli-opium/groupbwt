<?php

namespace App\ValueObject;

class Transaction
{
    public function __construct(
        private readonly string $bin,
        private readonly float $amount,
        private readonly string $currency,
    )
    {
    }

    public function getBin(): string
    {
        return $this->bin;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }
}