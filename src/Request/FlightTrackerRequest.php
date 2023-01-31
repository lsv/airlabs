<?php

declare(strict_types=1);

namespace Lsv\Airlabs\Request;

use Lsv\Airlabs\AbstractRequest;
use Lsv\Airlabs\DefaultOptionsTrait;
use Lsv\Airlabs\EitherIsRequiredTrait;
use Lsv\Airlabs\Response\FlightTrackerResponse;
use Lsv\Airlabs\Utils\BoundaryBox;
use Lsv\Airlabs\Utils\IcaoIataCode;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FlightTrackerRequest extends AbstractRequest
{
    use DefaultOptionsTrait;
    use EitherIsRequiredTrait;

    public function __construct(
        private readonly ?BoundaryBox $box = null,
        private readonly ?string $hex = null,
        private readonly ?string $registrationNumber = null,
        private readonly ?IcaoIataCode $airlineCode = null,
        private readonly ?string $flag = null,
        private readonly ?IcaoIataCode $flightCode = null,
        private readonly ?string $flightNumber = null,
        private readonly ?IcaoIataCode $departureAirport = null,
        private readonly ?IcaoIataCode $arrivalAirport = null
    ) {
        parent::__construct();

        $this->queryData->add([
            'bbox' => $this->box?->__toString(),
            'hex' => $this->hex,
            'reg_number' => $this->registrationNumber,
            'airline_icao' => $this->airlineCode?->icao,
            'airline_iata' => $this->airlineCode?->iata,
            'flag' => $this->flag,
            'flight_icao' => $this->flightCode?->icao,
            'flight_iata' => $this->flightCode?->iata,
            'flight_number' => $this->flightNumber,
            'dep_icao' => $this->departureAirport?->icao,
            'dep_iata' => $this->departureAirport?->iata,
            'arr_icao' => $this->arrivalAirport?->icao,
            'arr_iata' => $this->arrivalAirport?->iata,
        ]);
    }

    protected function validateQueryParameters(OptionsResolver $resolver): void
    {
        $this->setDefinedOptions($resolver, [
            'bbox' => null,
            'hex' => self::validateHexInput(),
            'reg_number' => null,
            'airline_icao' => null,
            'airline_iata' => null,
            'flag' => self::validateIso2CountryCode(),
            'flight_icao' => null,
            'flight_iata' => null,
            'flight_number' => null,
            'dep_icao' => null,
            'dep_iata' => null,
            'arr_icao' => null,
            'arr_iata' => null,
        ]);

        $this->eitherCanBeNullButNotBothCanHaveValue($resolver, 'airline_iata', 'airline_icao');
        $this->eitherCanBeNullButNotBothCanHaveValue($resolver, 'flight_iata', 'flight_icao');
        $this->eitherCanBeNullButNotBothCanHaveValue($resolver, 'dep_iata', 'dep_icao');
        $this->eitherCanBeNullButNotBothCanHaveValue($resolver, 'arr_iata', 'arr_icao');
    }

    protected function getHttpUrl(): string
    {
        return '/flights';
    }

    protected function getResponseClass(): string
    {
        return FlightTrackerResponse::class;
    }

    /**
     * @return FlightTrackerResponse[]
     *
     * @psalm-suppress MixedReturnStatement, MixedInferredReturnType
     */
    public function call(): array
    {
        return $this->doCall();
    }
}
