<?php

namespace App\Service;

use App\ValueObject\Transaction;

class ExchangeRateApiProvider implements RateProvider
{
    /**
     * public function __construct(private readonly HttpClientInterface $client)
     * {
     * }
     */
    public function getUrl(): string
    {
        return 'https://api.exchangeratesapi.io/latest';
    }

    public function getRateData(Transaction $transaction): float
    {
        /**
         * NOTICE:
         *
         * Given API is protected by ACCESS_KEY which is not provided, mock data is used instead!
         *
         * $response = $this->client->request('GET', $this->getUrl() . $transaction->getCurrency());
         * $data = json_decode($response->getContent(), true);
         */

        $rates = $this->getMockData()['rates'] ?? [];

        return isset($rates[$transaction->currency]) ? (float)$rates[$transaction->currency] : 0.0;
    }

    public function isRateNonExistent(float $exchangeRate): bool
    {
        return $exchangeRate === 0.;
    }

    private function getMockData(): array
    {
        return [
            "base" => "EUR",
            "date" => "2024-05-31",
            "rates" => [
                "USD" => 1.1154,
                "GBP" => 0.8564,
                "JPY" => 121.94,
                "CAD" => 1.5035,
                "AUD" => 1.6269
            ]
        ];
    }
}