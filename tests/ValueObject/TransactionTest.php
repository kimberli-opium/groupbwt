<?php

namespace App\Tests\ValueObject;

use App\ValueObject\Transaction;
use PHPUnit\Framework\TestCase;

class TransactionTest extends TestCase
{
    public function testIsCurrencyEuro_EuroCurrency_ReturnsTrue(): void
    {
        $transaction = new Transaction('123456', 100.00, 'EUR');
        $this->assertTrue($transaction->isCurrencyEuro());
    }

    public function testIsCurrencyEuro_NonEuroCurrency_ReturnsFalse(): void
    {
        $transaction = new Transaction('987654', 50.00, 'USD');
        $this->assertFalse($transaction->isCurrencyEuro());
    }

    public function testIsCurrencyEuro_CaseInsensitive_ReturnsTrue(): void
    {
        $transaction = new Transaction('987654', 50.00, 'eur');
        $this->assertTrue($transaction->isCurrencyEuro());
    }
}