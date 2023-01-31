<?php

declare(strict_types=1);

namespace Lsv\Airlabs\Response;

use Lsv\Airlabs\ResponseInterface;

class AirlineFleetFreeResponse implements ResponseInterface
{
    public string $hex = '';
    public ?string $airlineIcao = null;
    public ?string $airlineIata = null;
    public ?string $manufacturer = null;
    public ?string $icao = null;
    public ?string $iata = null;
}
