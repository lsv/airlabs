<?php

declare(strict_types=1);

namespace Lsv\AirlabsTests\Request;

use Lsv\Airlabs\Request\AirportRequest;
use Lsv\Airlabs\Response\AirportFreeResponse;
use Lsv\Airlabs\Response\AirportResponse;

class AirportRequestTest extends AbstractRequestTest
{
    protected function getRequestClass(): string
    {
        return AirportRequest::class;
    }

    public function testRequiredOptions(): void
    {
        $request = $this->makeRequest(__DIR__.'/Airport.json');
        self::assertTrue($request->getQueryData()->has('iata_code'));
        self::assertTrue($request->getQueryData()->has('icao_code'));
        self::assertTrue($request->getQueryData()->has('city_code'));
        self::assertTrue($request->getQueryData()->has('country_code'));

        /** @var AirportResponse[] $data */
        $data = $request->call();
        self::assertCount(1, $data);
        $d = $data[0];
        self::assertInstanceOf(AirportResponse::class, $d);
        self::assertSame('Paris Charles de Gaulle Airport', $d->name);
        self::assertSame('CDG', $d->iataCode);
        self::assertSame('LFPG', $d->icaoCode);
        self::assertSame('Charles de Gaulle internasjonale lufthavn', $d->names['no']);
        self::assertSame('فرودگاه پاری-شارل-دو-گل', $d->names['fa']);
        self::assertFalse($d->isMajor);
        self::assertTrue($d->isInternational);
    }

    public function testFree(): void
    {
        $request = $this->makeRequest(__DIR__.'/AirportFree.json');
        /** @var AirportFreeResponse[] $data */
        $data = $request->call();
        self::assertCount(1, $data);
        $d = $data[0];
        self::assertInstanceOf(AirportFreeResponse::class, $d);
    }

    public function testOptionalOptions(): void
    {
        $request = $this->makeRequest(__DIR__.'/Airport.json', [
            'countryCode' => 'DK',
        ]);
        $uri = $request->getRequest()->getUri();
        self::assertSame('country_code=DK&api_key=apikey', $uri->getQuery());
    }

    public function testUri(): void
    {
        $request = $this->makeRequest(__DIR__.'/Airport.json');
        $uri = $request->getRequest()->getUri();
        self::assertSame('/api/v9/airports', $uri->getPath());
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
            ['airportCode'],
        ];
    }
}
