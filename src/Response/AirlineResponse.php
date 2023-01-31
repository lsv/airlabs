<?php

declare(strict_types=1);

namespace Lsv\Airlabs\Response;

use Lsv\Airlabs\ResponseInterface;

class AirlineResponse implements ResponseInterface
{
    public string $name = '';
    public string $iataCode = '';
    public string $icaoCode = '';
    public string $slug = '';
    public int $iataPrefix = 0;
    public int $iataAccounting = 0;
    public string $callsign = '';
    public string $countryCode = '';
    public ?bool $iosaRegistered = null;
    public ?bool $isScheduled = null;
    public ?bool $isPassenger = null;
    public ?bool $isCargo = null;
    public ?bool $isInternational = null;
    public int $totalAircrafts = 0;
    public int $averageFleetAge = 0;
    public int $accidentsLast5y = 0;
    public int $crashesLast5y = 0;
    public string $website = '';
    public string $facebook = '';
    public string $twitter = '';
    public string $instagram = '';
    public string $linkedin = '';
}
