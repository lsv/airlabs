<?php

declare(strict_types=1);

namespace Lsv\Airlabs\Request;

use Lsv\Airlabs\AbstractRequest;
use Lsv\Airlabs\DefaultOptionsTrait;
use Lsv\Airlabs\EitherIsRequiredTrait;
use Lsv\Airlabs\Response\FlightScheduleResponse;
use Lsv\Airlabs\Utils\IcaoIataCode;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FlightScheduleRequest extends AbstractRequest
{
    use DefaultOptionsTrait;
    use EitherIsRequiredTrait;

    public function __construct(
        private readonly IcaoIataCode $departureAirport,
        private readonly IcaoIataCode $arrivalAirport,
        private readonly IcaoIataCode $airlineCode,
        private readonly ?IcaoIataCode $flightCode = null,
        private readonly ?string $flightNumber = null
    ) {
        parent::__construct();
        $this->queryData->add([
            'dep_iata' => $this->departureAirport->iata,
            'dep_icao' => $this->departureAirport->icao,
            'arr_iata' => $this->arrivalAirport->iata,
            'arr_icao' => $this->arrivalAirport->icao,
            'airline_iata' => $this->airlineCode->iata,
            'airline_icao' => $this->airlineCode->icao,
            'flight_iata' => $this->flightCode?->iata,
            'flight_icao' => $this->flightCode?->icao,
            'flight_number' => $this->flightNumber,
        ]);
    }

    protected function validateQueryParameters(OptionsResolver $resolver): void
    {
        $this->setDefinedOptions($resolver, [
            'dep_iata' => null,
            'dep_icao' => null,
            'arr_iata' => null,
            'arr_icao' => null,
            'airline_iata' => null,
            'airline_icao' => null,
            'flight_iata' => null,
            'flight_icao' => null,
            'flight_number' => null,
        ]);

        $this->eitherIsRequiredButNotBoth($resolver, 'dep_iata', 'dep_icao');
        $this->eitherIsRequiredButNotBoth($resolver, 'arr_iata', 'arr_icao');
        $this->eitherIsRequiredButNotBoth($resolver, 'airline_iata', 'airline_icao');
        $this->eitherCanBeNullButNotBothCanHaveValue($resolver, 'flight_iata', 'flight_icao');
    }

    protected function getHttpUrl(): string
    {
        return '/schedules';
    }

    protected function getResponseClass(): string
    {
        return FlightScheduleResponse::class;
    }

    /**
     * @return FlightScheduleResponse[]
     *
     * @psalm-suppress MixedReturnStatement, MixedInferredReturnType
     */
    public function call(): array
    {
        return $this->doCall();
    }
}
