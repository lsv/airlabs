<?php

declare(strict_types=1);

namespace Lsv\AirlabsTests\Request;

use Lsv\Airlabs\Request\FlightInformationRequest;
use Lsv\Airlabs\Response\FlightInformationResponse;
use Lsv\Airlabs\Utils\IcaoIataCode;

class FlightInformationRequestTest extends AbstractRequestTest
{
    public function testRequiredOptions(): void
    {
        $request = $this->makeRequest(__DIR__.'/information.json');
        self::assertTrue($request->getQueryData()->has('flight_icao'));
        self::assertTrue($request->getQueryData()->has('flight_iata'));
        $data = $request->call();
        self::assertInstanceOf(FlightInformationResponse::class, $data);
        self::assertSame(33.455017, $data->lat);
    }

    public function testOptionalOptions(): void
    {
        $this->expectNotToPerformAssertions();
    }

    public function testUri(): void
    {
        $request = $this->makeRequest(__DIR__.'/information.json');
        $uri = $request->getRequest()->getUri();
        self::assertSame('/api/v9/flight', $uri->getPath());
    }

    protected function getRequestClass(): string
    {
        return FlightInformationRequest::class;
    }

    protected function getRequiredRequestOptions(): array
    {
        return [
            'flightCode' => new IcaoIataCode('f_icao'),
        ];
    }

    protected function requiredOptionFieldsProvider(): array
    {
        return [['flightCode']];
    }

    protected function optionalOptionFieldsProvider(): array
    {
        return [];
    }
}
