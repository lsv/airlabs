<?php

declare(strict_types=1);

namespace Lsv\Airlabs\Request;

use Lsv\Airlabs\AbstractRequest;
use Lsv\Airlabs\DefaultOptionsTrait;
use Lsv\Airlabs\EitherIsRequiredTrait;
use Lsv\Airlabs\Response\AirportFreeResponse;
use Lsv\Airlabs\Response\AirportResponse;
use Lsv\Airlabs\Utils\IcaoIataCode;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AirportRequest extends AbstractRequest
{
    use DefaultOptionsTrait;
    use EitherIsRequiredTrait;

    public function __construct(
        readonly ?IcaoIataCode $airportCode = null,
        readonly ?string $cityCode = null,
        readonly ?string $countryCode = null,
    ) {
        parent::__construct();

        $this->queryData->add([
            'iata_code' => $this->airportCode?->iata,
            'icao_code' => $this->airportCode?->icao,
            'city_code' => $this->cityCode,
            'country_code' => $this->countryCode,
        ]);
    }

    /**
     * @return AirportResponse[]|AirportFreeResponse[]
     *
     * @psalm-suppress MixedReturnStatement, MixedInferredReturnType
     */
    public function call(): array
    {
        return $this->doCall();
    }

    protected function validateQueryParameters(OptionsResolver $resolver): void
    {
        $this->setDefinedOptions($resolver, [
            'iata_code' => null,
            'icao_code' => null,
            'city_code' => null,
            'country_code' => self::validateIso2CountryCode(),
        ]);

        $this->eitherCanBeNullButNotBothCanHaveValue($resolver, 'iata_code', 'icao_code');
    }

    protected function getHttpUrl(): string
    {
        return '/airports';
    }

    protected function getResponseClass(): string
    {
        return $this->useFreePlan ? AirportFreeResponse::class : AirportResponse::class;
    }
}
