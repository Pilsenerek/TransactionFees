<?php
declare(strict_types=1);

namespace App\Service;

class GeoLocation
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
        private BINInfoProvider $binInfoProvider,
    )
    {
    }

    public function isEu(string $BIN): bool
    {
        $countryCode = $this->binInfoProvider->retrieveCountryCode($BIN);
        if (\in_array($countryCode, $this->ueCountries)) {

            return true;
        }

        return false;
    }
}
