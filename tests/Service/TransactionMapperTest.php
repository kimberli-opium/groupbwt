<?php

namespace App\Tests\Service;

use App\Service\TransactionMapper;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class TransactionMapperTest extends TestCase
{
    public function testMap_ValidJsonFile_ReturnsTransactions(): void
    {
        $data = '{"bin": "45717360", "amount": "100.00", "currency": "EUR"}';

        $mapper = new TransactionMapper();

        $transactions = $mapper->map($data);

        $this->assertCount(1, $transactions);

        $this->assertEquals('45717360', $transactions[0]->bin);
        $this->assertEquals(100.00, $transactions[0]->amount);
        $this->assertEquals('EUR', $transactions[0]->currency);
    }

    public function testMap_InvalidJson_ThrowsException(): void
    {
        $data = '{"bin" => "45717360", "amount" => "100.00", "currency" => "EUR"}';

        $mapper = new TransactionMapper();

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Invalid JSON format: {"bin" => "45717360", "amount" => "100.00", "currency" => "EUR"}');

        $mapper->map($data);
    }
}