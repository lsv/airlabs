<?php

declare(strict_types=1);

namespace Lsv\Airlabs\Response;

use Lsv\Airlabs\ResponseInterface;

class AirportFreeResponse implements ResponseInterface
{
    public string $name = '';
    public string $iataCode = '';
    public string $icaoCode = '';
    public ?float $lat = null;
    public ?float $lng = null;
    public string $countryCode = '';
}
