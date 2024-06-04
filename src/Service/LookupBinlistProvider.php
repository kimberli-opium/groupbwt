<?php

namespace App\Service;

use App\ValueObject\CardInfo;
use App\ValueObject\Transaction;
use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class LookupBinlistProvider implements BinProvider
{
    public function __construct(
        private HttpClientInterface $client
    ) {
    }

    public function getUrl(): string
    {
        return 'https://lookup.binlist.net/';
    }

    public function getCardInfo(Transaction $transaction): CardInfo
    {
        $response = $this->client->request('GET', $this->getUrl() . $transaction->bin);
        $data = json_decode($response->getContent(), true);

        $alpha2 = $data['country']['alpha2'] ?? '';

        return new CardInfo($alpha2);
    }
}
