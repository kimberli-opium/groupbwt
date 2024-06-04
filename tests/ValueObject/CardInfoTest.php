<?php

namespace App\Tests\ValueObject;

use App\ValueObject\CardInfo;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class CardInfoTest extends TestCase
{
    public function testIsInEuropeanUnion_EuCountry_ReturnsTrue(): void
    {
        $cardInfo = new CardInfo('DE');
        $this->assertTrue($cardInfo->isInEuropeanUnion('DE'));
    }

    public function testIsInEuropeanUnion_NonEuCountry_ReturnsFalse(): void
    {
        $cardInfo = new CardInfo('US');
        $this->assertFalse($cardInfo->isInEuropeanUnion('US'));
    }

    public function testIsInEuropeanUnion_CaseInsensitive_ReturnsTrue(): void
    {
        $cardInfo = new CardInfo('fr');
        $this->assertTrue($cardInfo->isInEuropeanUnion('FR'));
    }
}