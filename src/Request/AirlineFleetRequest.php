<?php

declare(strict_types=1);

namespace Lsv\Airlabs\Request;

use Lsv\Airlabs\AbstractRequest;
use Lsv\Airlabs\DefaultOptionsTrait;
use Lsv\Airlabs\EitherIsRequiredTrait;
use Lsv\Airlabs\Response\AirlineFleetFreeResponse;
use Lsv\Airlabs\Response\AirlineFleetResponse;
use Lsv\Airlabs\Utils\IcaoIataCode;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AirlineFleetRequest extends AbstractRequest
{
    use DefaultOptionsTrait;
    use EitherIsRequiredTrait;

    public function __construct(
        readonly ?IcaoIataCode $airlineCode = null,
        readonly ?string $hex = null,
        readonly ?string $regNumber = null,
        readonly ?string $msn = null,
        readonly ?string $flag = null,
    ) {
        parent::__construct();
        $this->queryData->add([
            'airline_iata' => $this->airlineCode?->iata,
            'airline_icao' => $this->airlineCode?->icao,
            'hex' => $this->hex,
            'reg_number' => $this->regNumber,
            'msn' => $this->msn,
            'flag' => $this->flag,
        ]);
    }

    protected function validateQueryParameters(OptionsResolver $resolver): void
    {
        $this->setDefinedOptions($resolver, [
            'airline_iata' => null,
            'airline_icao' => null,
            'hex' => self::validateHexInput(),
            'reg_number' => null,
            'msn' => null,
            'flag' => self::validateIso2CountryCode(),
        ]);

        $this->eitherCanBeNullButNotBothCanHaveValue($resolver, 'airline_iata', 'airline_icao');
    }

    protected function getHttpUrl(): string
    {
        return '/fleets';
    }

    protected function getResponseClass(): string
    {
        return $this->useFreePlan ? AirlineFleetFreeResponse::class : AirlineFleetResponse::class;
    }

    /**
     * @return AirlineFleetResponse[]|AirlineFleetFreeResponse[]
     *
     * @psalm-suppress MixedReturnStatement, MixedInferredReturnType
     */
    public function call(): mixed
    {
        return $this->doCall();
    }
}
