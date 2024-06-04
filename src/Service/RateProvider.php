<?php

namespace App\Service;

use App\ValueObject\Transaction;

interface RateProvider
{
    public function getUrl(): string;
    public function getRateData(Transaction $transaction): float;
}