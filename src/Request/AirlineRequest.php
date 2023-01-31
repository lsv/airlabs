<?php

declare(strict_types=1);

namespace Lsv\Airlabs\Request;

use Lsv\Airlabs\AbstractRequest;
use Lsv\Airlabs\DefaultOptionsTrait;
use Lsv\Airlabs\EitherIsRequiredTrait;
use Lsv\Airlabs\Response\AirlineFreeResponse;
use Lsv\Airlabs\Response\AirlineResponse;
use Lsv\Airlabs\Utils\IcaoIataCode;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AirlineRequest extends AbstractRequest
{
    use DefaultOptionsTrait;
    use EitherIsRequiredTrait;

    public function __construct(
        readonly ?IcaoIataCode $airlineCode = null,
        readonly ?string $iataPrefix = null,
        readonly ?string $iataAccounting = null,
        readonly ?string $callsign = null,
        readonly ?string $name = null,
        readonly ?string $countryCode = null,
    ) {
        parent::__construct();

        $this->queryData->add([
            'iata_code' => $this->airlineCode?->iata,
            'icao_code' => $this->airlineCode?->icao,
            'iata_prefix' => $this->iataPrefix,
            'iata_accounting' => $this->iataAccounting,
            'callsign' => $this->callsign,
            'name' => $this->name,
            'country_code' => $this->countryCode,
        ]);
    }

    protected function validateQueryParameters(OptionsResolver $resolver): void
    {
        $this->setDefinedOptions($resolver, [
            'iata_code' => null,
            'icao_code' => null,
            'iata_prefix' => null,
            'iata_accounting' => null,
            'callsign' => null,
            'name' => null,
            'country_code' => self::validateIso2CountryCode(),
        ]);

        $this->eitherCanBeNullButNotBothCanHaveValue($resolver, 'iata_code', 'icao_code');
    }

    protected function getHttpUrl(): string
    {
        return '/airlines';
    }

    /**
     * @return \Lsv\Airlabs\Response\AirlineResponse[]|\Lsv\Airlabs\Response\AirlineFreeResponse[]
     *
     * @psalm-suppress MixedReturnStatement, MixedInferredReturnType
     */
    public function call(): array
    {
        return $this->doCall();
    }

    protected function getResponseClass(): string
    {
        return $this->useFreePlan ? AirlineFreeResponse::class : AirlineResponse::class;
    }
}
