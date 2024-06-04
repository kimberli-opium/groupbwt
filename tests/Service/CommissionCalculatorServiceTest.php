<?php

namespace App\Tests\Service;

use App\Service\CommissionCalculatorService;
use App\Service\ExchangeRateApiProvider;
use App\Service\LookupBinlistProvider;
use App\ValueObject\CardInfo;
use App\ValueObject\Transaction;
use PHPUnit\Framework\TestCase;

class CommissionCalculatorServiceTest extends TestCase
{
    public function testCalculates_CommissionForEUCountry(): void
    {
        $binProvider = $this->createMock(LookupBinlistProvider::class);
        $rateProvider = $this->createMock(ExchangeRateApiProvider::class);
        $service = new CommissionCalculatorService($binProvider, $rateProvider);

        $cardInfo = new CardInfo('FR');
        $transaction = new Transaction('1111111', 100.0, 'EUR');

        $rateProvider->expects($this->never())
            ->method('isRateNonExistent');

        $rateProvider->method('getRateData')->willReturn(1.0);
        $binProvider->method('getCardInfo')->willReturn($cardInfo);

        $commission = $service->calculate($transaction);

        $this->assertEquals(1.0, $commission);
    }

    public function testCalculates_CommissionForNonEUCountry(): void
    {
        $binProvider = $this->createMock(LookupBinlistProvider::class);
        $rateProvider = $this->createMock(ExchangeRateApiProvider::class);
        $service = new CommissionCalculatorService($binProvider, $rateProvider);

        $cardInfo = new CardInfo('USA');
        $transaction = new Transaction('1111111', 100.0, 'USD');

        $rateProvider->expects($this->once())
            ->method('isRateNonExistent')
            ->willReturn(false);

        $rateProvider->method('getRateData')->willReturn(1.2);
        $binProvider->method('getCardInfo')->willReturn($cardInfo);

        $commission = $service->calculate($transaction);

        $this->assertEquals(1.67, $commission);
    }

    public function testCalculates_CommissionForEUCountry_NoRateExistent(): void
    {
        $binProvider = $this->createMock(LookupBinlistProvider::class);
        $rateProvider = $this->createMock(ExchangeRateApiProvider::class);
        $service = new CommissionCalculatorService($binProvider, $rateProvider);

        $cardInfo = new CardInfo('USA');
        $transaction = new Transaction('1111111', 100.0, 'USD');

        $rateProvider->expects($this->once())
            ->method('isRateNonExistent')
            ->willReturn(false);

        $rateProvider->method('getRateData')->willReturn(1.2);
        $binProvider->method('getCardInfo')->willReturn($cardInfo);

        $commission = $service->calculate($transaction);

        $this->assertEquals(1.67, $commission);
    }
}