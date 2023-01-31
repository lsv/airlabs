<?php

declare(strict_types=1);

namespace Lsv\AirlabsTests\Request;

use Lsv\Airlabs\Response\AirlineRouteResponse;
use Lsv\Airlabs\Utils\IcaoIataCode;

class AirlineRouteRequestTest extends AbstractRequestTest
{
    public function testRequiredOptions(): void
    {
        $request = $this->makeRequest(__DIR__.'/airline_routes.json');
        self::assertTrue($request->getQueryData()->has('dep_iata'));
        self::assertTrue($request->getQueryData()->has('dep_icao'));
        self::assertTrue($request->getQueryData()->has('arr_iata'));
        self::assertTrue($request->getQueryData()->has('arr_icao'));
        self::assertTrue($request->getQueryData()->has('airline_iata'));
        self::assertTrue($request->getQueryData()->has('airline_icao'));
        self::assertTrue($request->getQueryData()->has('flight_iata'));
        self::assertTrue($request->getQueryData()->has('flight_icao'));
        self::assertTrue($request->getQueryData()->has('flight_number'));

        /** @var AirlineRouteResponse[] $data */
        $data = $request->call();
        self::assertCount(1, $data);
        $d = $data[0];
        self::assertInstanceOf(\Lsv\Airlabs\Response\AirlineRouteResponse::class, $d);
        self::assertSame(['1'], $d->depTerminals);
        self::assertSame(['1', 'T3'], $d->arrTerminals);
        self::assertSame(['mon', 'wed', 'sat'], $d->days);
        self::assertSame(270, $d->duration);
    }

    public function testOptionalOptions(): void
    {
        $request = $this->makeRequest(__DIR__.'/airline_routes.json', ['flightNumber' => '123']);
        self::assertSame('123', $request->getQueryData()->get('flight_number'));
        $uri = $request->getRequest()->getUri();
        self::assertSame('dep_icao=d_icao&arr_icao=a_iata&airline_icao=f_icao&flight_number=123&api_key=apikey', $uri->getQuery());
    }

    public function testUri(): void
    {
        $request = $this->makeRequest(__DIR__.'/airline_routes.json');
        $uri = $request->getRequest()->getUri();
        self::assertSame('/api/v9/routes', $uri->getPath());
    }

    protected function getRequestClass(): string
    {
        return \Lsv\Airlabs\Request\AirlineRouteRequest::class;
    }

    protected function getRequiredRequestOptions(): array
    {
        return [
            'departureAirport' => new IcaoIataCode('d_icao'),
            'arrivalAirport' => new IcaoIataCode('a_iata'),
            'airlineCode' => new IcaoIataCode('f_icao'),
        ];
    }

    protected function requiredOptionFieldsProvider(): array
    {
        return [
            ['departureAirport'],
        ['arrivalAirport'],
        ['airlineCode'],
        ];
    }

    protected function optionalOptionFieldsProvider(): array
    {
        return [
           ['flightCode'],
        ];
    }
}
