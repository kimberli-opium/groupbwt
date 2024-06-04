<?php

namespace App\ValueObject;

readonly class CardInfo
{
    private const EU_COUNTRIES = [
        'AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI', 'FR',
        'GR', 'HR', 'HU', 'IE', 'IT', 'LT', 'LU', 'LV', 'MT', 'NL', 'PO',
        'PT', 'RO', 'SE', 'SI', 'SK'
    ];
    public function __construct(
        public string $countryAlpha2Code
    ) {
    }

    public function isInEuropeanUnion(string $countryAlpha2Code): bool
    {
        return in_array($countryAlpha2Code, self::EU_COUNTRIES, true);
    }
}