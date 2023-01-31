<?php

declare(strict_types=1);

namespace Lsv\AirlabsTests\Request;

use Lsv\Airlabs\Request\FlightScheduleRequest;
use Lsv\Airlabs\Utils\IcaoIataCode;

class FlightScheduleRequestTest extends AbstractRequestTest
{
    public function testRequiredOptions(): void
    {
        $request = $this->makeRequest(__DIR__.'/schedule.json');
        self::assertTrue($request->getQueryData()->has('dep_iata'));
        self::assertTrue($request->getQueryData()->has('dep_icao'));
        self::assertTrue($request->getQueryData()->has('arr_iata'));
        self::assertTrue($request->getQueryData()->has('arr_icao'));
        self::assertTrue($request->getQueryData()->has('airline_iata'));
        self::assertTrue($request->getQueryData()->has('airline_icao'));
        self::assertTrue($request->getQueryData()->has('flight_iata'));
        self::assertTrue($request->getQueryData()->has('flight_icao'));
        self::assertTrue($request->getQueryData()->has('flight_number'));

        /** @var \Lsv\Airlabs\Response\FlightScheduleResponse[] $data */
        $data = $request->call();
        self::assertCount(1, $data);
        $d = $data[0];
        self::assertInstanceOf(\Lsv\Airlabs\Response\FlightScheduleResponse::class, $d);
        self::assertSame('BA', $d->airlineIata);
        self::assertSame('BAW', $d->airlineIcao);
        self::assertSame('2021-07-14 19:53', $d->depTime);
    }

    public function testOptionalOptions(): void
    {
        $request = $this->makeRequest(__DIR__.'/schedule.json', params: [
            'flightNumber' => 'flight',
        ]);
        $uri = $request->getRequest()->getUri();
        self::assertSame('dep_icao=d_icao&arr_iata=a_iata&airline_icao=al_icao&flight_number=flight&api_key=apikey', $uri->getQuery());
    }

    public function testUri(): void
    {
        $request = $this->makeRequest(__DIR__.'/schedule.json');
        $uri = $request->getRequest()->getUri();
        self::assertSame('/api/v9/schedules', $uri->getPath());
    }

    protected function getRequestClass(): string
    {
        return FlightScheduleRequest::class;
    }

    protected function getRequiredRequestOptions(): array
    {
        return [
            'departureAirport' => new IcaoIataCode('d_icao'),
            'arrivalAirport' => new IcaoIataCode(null, 'a_iata'),
            'airlineCode' => new IcaoIataCode('al_icao'),
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
