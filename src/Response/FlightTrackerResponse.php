<?php

declare(strict_types=1);

namespace Lsv\Airlabs\Response;

use Lsv\Airlabs\ResponseInterface;

class FlightTrackerResponse implements ResponseInterface
{
    public ?string $hex = null;
    public ?string $regNumber = null;
    public ?int $alt = null;
    public ?int $speed = null;
    public ?float $vSpeed = null;
    public ?string $squawk = null;
    public ?string $airlineIcao = null;
    public ?string $airlineIata = null;
    public ?string $flightIcao = null;
    public ?string $flightIata = null;
    public ?string $flightNumber = null;
    public ?string $depIcao = null;
    public ?string $arrIcao = null;
    public ?string $arrIata = null;
    public ?int $updated = null;
    public ?string $status = null;
    public ?string $flag = null;
    public ?float $lat = null;
    public ?float $lng = null;
    public ?int $dir = null;
    public ?string $aircraftIcao = null;
    public ?string $depIata = null;
}
