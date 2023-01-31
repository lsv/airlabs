<?php

declare(strict_types=1);

namespace Lsv\Airlabs\Response;

class AirportResponse extends AirportFreeResponse
{
    public int $alt = 0;
    public string $city = '';
    public string $cityCode = '';
    public string $unLocode = '';
    public string $timezone = '';
    public string $phone = '';
    public string $website = '';
    public string $facebook = '';
    public string $instagram = '';
    public string $linkedin = '';
    public string $twitter = '';
    public string $slug = '';

    /**
     * @var array<string, string>
     */
    public array $names = [];
    public int $runways = 0;
    public int $departures = 0;
    public int $connections = 0;
    public ?bool $isMajor = null;
    public ?bool $isInternational = null;
}
