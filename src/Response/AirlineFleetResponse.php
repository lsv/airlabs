<?php

declare(strict_types=1);

namespace Lsv\Airlabs\Response;

class AirlineFleetResponse extends AirlineFleetFreeResponse
{
    public string $regNumber = '';
    public string $flag = '';
    public ?int $seen = null;
    public string $model = '';
    public string $engine = '';
    public string $engineCount = '';
    public string $type = '';
    public string $category = '';
    public ?int $built = null;
    public ?int $age = null;
    public string $msn = '';
    public string $line = '';
}
