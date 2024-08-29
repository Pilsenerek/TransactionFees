<?php
declare(strict_types=1);

namespace App\Service;

interface BINInfoProvider
{
    public function retrieveCountryCode(string $bin): string;
}
