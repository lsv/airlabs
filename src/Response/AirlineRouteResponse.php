<?php

declare(strict_types=1);

namespace Lsv\Airlabs\Response;

use Lsv\Airlabs\ResponseInterface;

class AirlineRouteResponse implements ResponseInterface
{
    public string $airlineIata = '';
    public string $airlineIcao = '';
    public string $flightIata = '';
    public string $flightIcao = '';
    public string $flightNumber = '';
    public string $csAirlineIata = '';
    public string $csFlightIata = '';
    public string $csFlightNumber = '';
    public string $depIata = '';
    public string $depIcao = '';
    public string $depTime = '';
    public string $depTimeUtc = '';
    /**
     * @var string[]
     */
    public array $depTerminals = [];
    public string $arrIata = '';
    public string $arrIcao = '';
    public string $arrTime = '';
    public string $arrTimeUtc = '';
    /**
     * @var string[]
     */
    public array $arrTerminals = [];
    public ?int $duration = null;
    /**
     * @var string[]
     */
    public array $days = [];
    public ?int $counter = null;
    public ?\DateTimeInterface $updated = null;
}
