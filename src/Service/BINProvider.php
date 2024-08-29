<?php
declare(strict_types=1);

namespace App\Service;

interface BINProvider
{

    public function retrieveCountryCode(string $bin): string;
}
