<?php

declare(strict_types=1);

namespace Lsv\Airlabs\Utils;

readonly class BoundaryBox implements \Stringable
{
    public function __construct(
        private float $southWestLatitude,
        private float $southWestLongitude,
        private float $northEastLatitude,
        private float $northEastLongitude,
    ) {
    }

    public function __toString(): string
    {
        return sprintf(
            '%s,%s,%s,%s',
            $this->southWestLatitude,
            $this->southWestLongitude,
            $this->northEastLatitude,
            $this->northEastLongitude
        );
    }
}
