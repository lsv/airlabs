<?php

declare(strict_types=1);

namespace Lsv\AirlabsTests\Request;

use Lsv\Airlabs\Request\FlightTrackerRequest;
use Lsv\Airlabs\Response\FlightTrackerResponse;
use Lsv\Airlabs\Utils\BoundaryBox;

class FlightTrackerRequestTest extends AbstractRequestTest
{
    public function testRequiredOptions(): void
    {
        $request = $this->makeRequest(__DIR__.'/tracker.json');
        self::assertTrue($request->getQueryData()->has('bbox'));
        self::assertTrue($request->getQueryData()->has('hex'));
        self::assertTrue($request->getQueryData()->has('reg_number'));
        self::assertTrue($request->getQueryData()->has('airline_icao'));
        self::assertTrue($request->getQueryData()->has('airline_iata'));
        self::assertTrue($request->getQueryData()->has('flag'));
        self::assertTrue($request->getQueryData()->has('flight_icao'));
        self::assertTrue($request->getQueryData()->has('flight_iata'));
        self::assertTrue($request->getQueryData()->has('flight_number'));
        self::assertTrue($request->getQueryData()->has('dep_icao'));
        self::assertTrue($request->getQueryData()->has('dep_iata'));
        self::assertTrue($request->getQueryData()->has('arr_icao'));
        self::assertTrue($request->getQueryData()->has('arr_iata'));

        /** @var \Lsv\Airlabs\Response\FlightTrackerResponse[] $data */
        $data = $request->call();
        self::assertCount(1, $data);
        $d = $data[0];
        self::assertInstanceOf(FlightTrackerResponse::class, $d);
        self::assertSame('780695', $d->hex);
        self::assertSame('B-5545', $d->regNumber);
        self::assertSame('CN', $d->flag);
        self::assertSame(28.397377, $d->lat);
        self::assertSame(115.1008, $d->lng);
    }

    public function testOptionalOptions(): void
    {
        $box = new BoundaryBox(1.1234, 2.1234, 3.1234, 4.1234);
        $request = $this->makeRequest(__DIR__.'/tracker.json', params: [
            'box' => $box,
        ]);
        $uri = $request->getRequest()->getUri();
        self::assertSame('bbox=1.1234%2C2.1234%2C3.1234%2C4.1234&api_key=apikey', $uri->getQuery());
    }

    public function testUri(): void
    {
        $request = $this->makeRequest(__DIR__.'/tracker.json');
        $uri = $request->getRequest()->getUri();
        self::assertSame('/api/v9/flights', $uri->getPath());
    }

    protected function getRequestClass(): string
    {
        return FlightTrackerRequest::class;
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
            ['flightCode'],
            ['departureAirport'],
            ['arrivalAirport'],
        ];
    }
}
