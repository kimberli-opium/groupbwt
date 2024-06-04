<?php

namespace App\Service;

use App\ValueObject\CardInfo;
use App\ValueObject\Transaction;

interface BinProvider
{
    public function getUrl(): string;
    public function getCardInfo(Transaction $transaction): CardInfo;
}