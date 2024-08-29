<?php
declare(strict_types=1);

namespace App\Service;

class LookUpBINProvider implements BINProvider
{
    private const BIN_URL = 'https://lookup.binlist.net/';

    private array $binData = [];

    /**
     * @throws \Exception
     */
    public function retrieveCountryCode(string $bin): string
    {
        if (empty($this->binData)) {
            $binJson = file_get_contents(self::BIN_URL . $bin);
            $binArray = json_decode($binJson, true);
            if (empty($binArray['country']['alpha2'])) {
                throw new \Exception(sprintf('Impossible to retrieve data from URL: %s', self::BIN_URL));
            }
            $this->binData = $binArray;
        }

        return $this->binData['country']['alpha2'];
    }
}
