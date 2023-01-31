<?php

declare(strict_types=1);

namespace Lsv\Airlabs\Utils;

readonly class IcaoIataCode
{
    public function __construct(
        public ?string $icao = null,
        public ?string $iata = null
    ) {
    }
}
