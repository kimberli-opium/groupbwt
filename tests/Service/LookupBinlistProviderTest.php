<?php

namespace App\Tests\Service;

use App\Service\LookupBinlistProvider;
use App\ValueObject\CardInfo;
use App\ValueObject\Transaction;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class LookupBinlistProviderTest extends TestCase
{
    public function testGetCardInfo_SuccessfulResponse_ReturnsCardInfo(): void
    {
        $mockClient = $this->createMock(HttpClientInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $responseData = [
            'country' => [
                'alpha2' => 'DE',
            ],
        ];

        $mockClient->expects($this->once())
            ->method('request')
            ->with('GET', 'https://lookup.binlist.net/45717360')
            ->willReturn($response);

        $response->expects($this->once())
            ->method('getContent')
            ->willReturn(json_encode($responseData));

        $provider = new LookupBinlistProvider($mockClient);
        $transaction = new Transaction('45717360', 100.00, 'EUR');

        $cardInfo = $provider->getCardInfo($transaction);

        $this->assertEquals('DE', $cardInfo->countryAlpha2Code);
    }

    public function testGetCardInfo_EmptyAlpha2_ReturnsEmptyCardInfo(): void
    {
        $mockClient = $this->createMock(HttpClientInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $responseData = [
            'country' => [],
        ];

        $mockClient->expects($this->once())
            ->method('request')
            ->with('GET', 'https://lookup.binlist.net/987654')
            ->willReturn($response);

        $response->expects($this->once())
            ->method('getContent')
            ->willReturn(json_encode($responseData));

        $provider = new LookupBinlistProvider($mockClient);
        $transaction = new Transaction('987654', 50.00, 'USD');

        $cardInfo = $provider->getCardInfo($transaction);

        $this->assertInstanceOf(CardInfo::class, $cardInfo);
        $this->assertEquals('', $cardInfo->countryAlpha2Code);
    }
}