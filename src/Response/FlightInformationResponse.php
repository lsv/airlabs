<?php

declare(strict_types=1);

namespace Lsv\Airlabs\Response;

use Lsv\Airlabs\ResponseInterface;

class FlightInformationResponse implements ResponseInterface
{
    public ?string $aircraftIcao = null;
    public ?string $flag = null;
    public ?float $lat = null;
    public ?float $lng = null;
    public ?int $dir = null;
    public ?string $airlineIata = null;
    public ?string $flightIata = null;
    public ?string $flightNumber = null;
    public ?string $depIata = null;
    public ?string $depTime = null;
    public ?string $arrIata = null;
    public ?string $arrTime = null;
    public ?string $manufacturer = null;
    public ?string $hex = null;
    public ?string $regNumber = null;
    public ?int $alt = null;
    public ?int $speed = null;
    public ?int $vSpeed = null;
    public ?string $squawk = null;
    public ?string $airlineIcao = null;
    public ?string $flightIcao = null;
    public ?string $csAirlineIata = null;
    public ?string $csFlightIata = null;
    public ?string $csFlightNumber = null;
    public ?string $depIcao = null;
    public ?string $depTerminal = null;
    public ?string $depGate = null;
    public ?int $depTimeTs = null;
    public ?string $depTimeUtc = null;
    public ?string $depEstimated = null;
    public ?int $depEstimatedTs = null;
    public ?string $depEstimatedUtc = null;
    public ?string $arrIcao = null;
    public ?string $arrTerminal = null;
    public ?string $arrGate = null;
    public ?string $arrBaggage = null;
    public ?int $arrTimeTs = null;
    public ?string $arrTimeUtc = null;
    public ?string $arrEstimated = null;
    public ?int $arrEstimatedTs = null;
    public ?string $arrEstimatedUtc = null;
    public ?int $duration = null;
    public ?string $delayed = null;
    public ?int $updated = null;
    public ?string $status = null;
    public ?string $model = null;
    public ?string $msn = null;
    public ?string $type = null;
    public ?string $engine = null;
    public ?string $engineCount = null;
    public ?int $built = null;
    public ?int $age = null;
}
