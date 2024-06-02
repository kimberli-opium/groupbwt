<?php

namespace App\Service;

use App\ValueObject\Transaction;
use RuntimeException;

class TransactionMapper
{
    public function map(string $filePath): array
    {
        $transactions = [];

        $fileContent = file_get_contents($filePath);
        if ($fileContent === false) {
            throw new RuntimeException("Unable to read file: $filePath");
        }

        $lines = explode("\n", trim($fileContent));

        foreach ($lines as $line) {
            $transactionData = json_decode($line, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new RuntimeException("Invalid JSON format: $line");
            }

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