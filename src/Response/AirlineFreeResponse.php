<?php

declare(strict_types=1);

namespace Lsv\Airlabs\Response;

use Lsv\Airlabs\ResponseInterface;

class AirlineFreeResponse implements ResponseInterface
{
    public string $name = '';
    public string $iataCode = '';
    public string $icaoCode = '';
}
