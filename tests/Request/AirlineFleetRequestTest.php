<?php

declare(strict_types=1);

namespace Lsv\AirlabsTests\Request;

use Lsv\Airlabs\Request\AirlineFleetRequest;
use Lsv\Airlabs\Response\AirlineFleetFreeResponse;
use Lsv\Airlabs\Response\AirlineFleetResponse;
use Lsv\Airlabs\Utils\IcaoIataCode;

class AirlineFleetRequestTest extends AbstractRequestTest
{
    protected function getRequestClass(): string
    {
        return AirlineFleetRequest::class;
    }

    public function testRequiredOptions(): void
    {
        $request = $this->makeRequest(__DIR__.'/AirlineFleet.json');
        self::assertTrue($request->getQueryData()->has('airline_iata'));
        self::assertTrue($request->getQueryData()->has('airline_icao'));
        self::assertTrue($request->getQueryData()->has('hex'));
        self::assertTrue($request->getQueryData()->has('reg_number'));
        self::assertTrue($request->getQueryData()->has('msn'));
        self::assertTrue($request->getQueryData()->has('flag'));

        /** @var AirlineFleetResponse[] $data */
        $data = $request->call();
        self::assertCount(1, $data);
        $d = $data[0];
        self::assertInstanceOf(AirlineFleetResponse::class, $d);
        self::assertSame('A9D286', $d->hex);
        self::assertSame('N732AN', $d->regNumber);
        self::assertSame('US', $d->flag);
        self::assertSame('AAL', $d->airlineIcao);
        self::assertSame('AA', $d->airlineIata);
        self::assertSame(172540, $d->seen);
        self::assertSame('BOEING', $d->manufacturer);
    }

    public function testFree(): void
    {
        $request = $this->makeRequest(__DIR__.'/AirlineFleetFree.json');

        /** @var AirlineFleetFreeResponse[] $data */
        $data = $request->call();
        self::assertCount(2, $data);
        $d = $data[0];
        self::assertInstanceOf(AirlineFleetFreeResponse::class, $d);
        self::assertSame('A08E82', $d->hex);
    }

    public function testOptionalOptions(): void
    {
        $request = $this->makeRequest(__DIR__.'/AirlineFleet.json', [
            'airlineCode' => new IcaoIataCode('icao', null),
        ]);
        self::assertSame('icao', $request->getQueryData()->get('airline_icao'));
        $uri = $request->getRequest()->getUri();
        self::assertSame('airline_icao=icao&api_key=apikey', $uri->getQuery());
    }

    public function testUri(): void
    {
        $request = $this->makeRequest(__DIR__.'/AirlineFleet.json');
        $uri = $request->getRequest()->getUri();
        self::assertSame('/api/v9/fleets', $uri->getPath());
        self::assertSame('api_key=apikey', $uri->getQuery());
    }

    protected function getRequiredRequestOptions(): array
    {
        return [];
    }

    protected function requiredOptionFieldsProvider(): array
    {
        return [];
    }

    protected function optionalOptionFieldsProvider(): array
    {
        return [
            ['airlineCode'],
        ];
    }
}
