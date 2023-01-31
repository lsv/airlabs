<?php

declare(strict_types=1);

namespace Lsv\Airlabs\Request;

use Lsv\Airlabs\AbstractRequest;
use Lsv\Airlabs\DefaultOptionsTrait;
use Lsv\Airlabs\EitherIsRequiredTrait;
use Lsv\Airlabs\Response\FlightInformationResponse;
use Lsv\Airlabs\Utils\IcaoIataCode;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FlightInformationRequest extends AbstractRequest
{
    use DefaultOptionsTrait;
    use EitherIsRequiredTrait;

    public function __construct(
        private readonly IcaoIataCode $flightCode
    ) {
        parent::__construct();
        $this->queryData->add([
            'flight_icao' => $this->flightCode->icao,
            'flight_iata' => $this->flightCode->iata,
        ]);
    }

    protected function validateQueryParameters(OptionsResolver $resolver): void
    {
        $this->setDefinedOptions($resolver, [
            'flight_icao' => null,
            'flight_iata' => null,
        ]);

        $this->eitherIsRequiredButNotBoth($resolver, 'flight_icao', 'flight_iata');
    }

    protected function getHttpUrl(): string
    {
        return '/flight';
    }

    protected function getResponseClass(): string
    {
        return FlightInformationResponse::class;
    }

    protected function responseIsArray(): bool
    {
        return false;
    }

    /**
     * @psalm-suppress MixedReturnStatement, MixedInferredReturnType
     */
    public function call(): FlightInformationResponse
    {
        return $this->doCall();
    }
}
