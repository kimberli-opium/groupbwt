<?php

namespace App\Service;

use App\ValueObject\CardInfo;
use App\ValueObject\Transaction;

readonly class CommissionCalculatorService
{
    public function __construct(
        private BinProvider $binProvider,
        private RateProvider $rateProvider,
    ) {
    }

    public function calculate(Transaction $transaction): float
    {
        $cardInfo = $this->binProvider->getCardInfo($transaction);
        $countryAlpha2Code = $cardInfo->countryAlpha2Code;

        $exchangeRate = $this->rateProvider->getRateData($transaction);
        $fixedAmount = $this->calculateFixedAmount($transaction, $this->rateProvider, $exchangeRate);

        $commissionRate = $this->getCommissionRate($cardInfo, $countryAlpha2Code);

        return $this->calculateCommission($fixedAmount, $commissionRate);
    }

    private function calculateFixedAmount(
        Transaction $transaction,
        RateProvider $rateProvider,
        float $exchangeRate
    ): float
    {
        if ($transaction->isCurrencyEuro() || $rateProvider->isRateNonExistent($exchangeRate)) {
            return $transaction->amount;
        }

        return $transaction->amount / $exchangeRate;
    }

    private function getCommissionRate(CardInfo $cardInfo, string $countryAlpha2Code): float
    {
        return $cardInfo->isInEuropeanUnion($countryAlpha2Code) ? 0.01 : 0.02;
    }

    private function calculateCommission(float $fixedAmount, float $commissionRate): float
    {
        return ceil($fixedAmount * $commissionRate * 100) / 100;
    }
}