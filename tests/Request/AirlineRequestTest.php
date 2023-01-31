<?php

declare(strict_types=1);

namespace Lsv\AirlabsTests\Request;

use Lsv\Airlabs\Request\AirlineRequest;
use Lsv\Airlabs\Response\AirlineResponse;
use Lsv\Airlabs\Utils\IcaoIataCode;

class AirlineRequestTest extends AbstractRequestTest
{
    protected function getRequestClass(): string
    {
        return AirlineRequest::class;
    }

    public function testRequiredOptions(): void
    {
        $request = $this->makeRequest(__DIR__.'/airlines.json');
        self::assertTrue($request->getQueryData()->has('iata_code'));
        self::assertTrue($request->getQueryData()->has('iata_prefix'));
        self::assertTrue($request->getQueryData()->has('iata_accounting'));
        self::assertTrue($request->getQueryData()->has('icao_code'));
        self::assertTrue($request->getQueryData()->has('callsign'));
        self::assertTrue($request->getQueryData()->has('name'));
        self::assertTrue($request->getQueryData()->has('country_code'));

        /** @var AirlineResponse[] $data */
        $data = $request->call();
        self::assertCount(1, $data);
        $d = $data[0];
        self::assertInstanceOf(AirlineResponse::class, $d);
        self::assertSame('American Airlines', $d->name);
        self::assertTrue($d->iosaRegistered);
        self::assertTrue($d->isScheduled);
        self::assertTrue($d->isPassenger);
        self::assertTrue($d->isCargo);
        self::assertTrue($d->isInternational);
        self::assertSame(0, $d->crashesLast5y);
    }

    public function testOptionalOptions(): void
    {
        $request = $this->makeRequest(__DIR__.'/airlines.json', params: [
            'airlineCode' => new IcaoIataCode(null, 'iata'),
        ]);
        $uri = $request->getRequest()->getUri();
        self::assertSame('iata_code=iata&api_key=apikey', $uri->getQuery());
    }

    public function testFreeData(): void
    {
        $request = $this->makeRequest(__DIR__.'/airlines_free.json');
        /** @var \Lsv\Airlabs\Response\AirlineFreeResponse[] $data */
        $data = $request->call();
        self::assertCount(2, $data);
        $d = $data[0];
        self::assertInstanceOf(\Lsv\Airlabs\Response\AirlineFreeResponse::class, $d);
    }

    public function testUri(): void
    {
        $request = $this->makeRequest(__DIR__.'/airlines.json');
        $uri = $request->getRequest()->getUri();
        self::assertSame('/api/v9/airlines', $uri->getPath());
        self::assertSame('api_key=apikey', $uri->getQuery());
    }

    public function testNoApiKeySet(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('API key is not set, use "setApiKey" first.');

        $request = new AirlineRequest();
        $request->call();
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
