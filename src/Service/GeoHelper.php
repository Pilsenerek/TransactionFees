<?php
declare(strict_types=1);

namespace App\Service;

class GeoHelper
{

    /**
     * @todo move it into configuration
     */
    private array $ueCountries = [
        'AT',
        'BE',
        'BG',
        'CY',
        'CZ',
        'DE',
        'DK',
        'EE',
        'ES',
        'FI',
        'FR',
        'GR',
        'HR',
        'HU',
        'IE',
        'IT',
        'LT',
        'LU',
        'LV',
        'MT',
        'NL',
        'PO',
        'PT',
        'RO',
        'SE',
        'SI',
        'SK',
    ];

    public function __construct(
        private BINProvider $binProvider,
    )
    {
    }

    public function isEu(string $bin): bool
    {
        $countryCode = $this->binProvider->retrieveCountryCode($bin);
        if (in_array($countryCode, $this->ueCountries)) {

            return true;
        }

        return false;
    }
}
