<?php

namespace App\Service;

use App\ValueObject\Transaction;
use RuntimeException;

class TransactionMapper
{
    public function map(string $fileContent): array
    {
        $transactions = [];
        $lines = explode("\n", trim($fileContent));

        foreach ($lines as $line) {
            if (!json_validate($line)) {
                throw new RuntimeException("Invalid JSON format: $line");
            }
            $transactionData = json_decode($line, true);

            $transaction = new Transaction(
                $transactionData['bin'],
                (float)$transactionData['amount'],
                $transactionData['currency']
            );

            $transactions[] = $transaction;
        }

        return $transactions;
    }
}