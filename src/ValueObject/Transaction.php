<?php

namespace App\ValueObject;

readonly class Transaction
{
    public function __construct(
        public string $bin,
        public float  $amount,
        public string $currency,
    )
    {
    }

    public function isCurrencyEuro(): bool
    {
        return $this->currency === 'EUR';
    }
}