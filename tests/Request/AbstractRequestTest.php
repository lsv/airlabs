<?php

declare(strict_types=1);

namespace Lsv\AirlabsTests\Request;

use Lsv\Airlabs\RequestInterface;
use Lsv\Airlabs\Utils\IcaoIataCode;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\HttplugClient;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;

abstract class AbstractRequestTest extends TestCase
{
    abstract public function testRequiredOptions(): void;

    abstract public function testOptionalOptions(): void;

    abstract public function testUri(): void;

    /**
     * @return class-string<RequestInterface>
     */
    abstract protected function getRequestClass(): string;

    /**
     * @return array<string, mixed>
     */
    abstract protected function getRequiredRequestOptions(): array;

    public function testEmptyData(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Could not get response from data');

        $request = $this->makeRequest(__DIR__.'/emptyData.json');
        $request->call();
    }

    /**
     * @param array<string, mixed> $params
     */
    protected function makeRequest(string $jsonFile, array $params = []): RequestInterface
    {
        $client = new MockHttpClient();
        $client->setResponseFactory(new MockResponse((string) file_get_contents($jsonFile)));

        $params = array_merge($this->getRequiredRequestOptions(), $params);

        $object = $this->getRequestClass();
        $request = new $object(...$params);
        $request->setClient(new HttplugClient($client));
        $request->setApiKey('apikey');

        return $request;
    }

    /**
     * @return list<string[]>
     */
    abstract protected function requiredOptionFieldsProvider(): array;

    /**
     * @return list<string[]>
     */
    abstract protected function optionalOptionFieldsProvider(): array;

    /**
     * @dataProvider requiredOptionFieldsProvider
     */
    public function testRequiredOptionFields(string $field): void
    {
        $this->expectException(InvalidOptionsException::class);

        $request = $this->makeRequest(__DIR__.'/airlines.json', params: [
            $field => new IcaoIataCode('icao', 'iata'),
        ]);
        $request->call();
    }

    /**
     * @dataProvider optionalOptionFieldsProvider
     */
    public function testOptionalOptionFieldsProviderNotBoth(string $field): void
    {
        $this->expectException(InvalidOptionsException::class);

        $request = $this->makeRequest(__DIR__.'/airlines.json', params: [
            $field => new IcaoIataCode('icao', 'iata'),
        ]);
        $request->call();
    }

    /**
     * @dataProvider optionalOptionFieldsProvider
     */
    public function testOptionalOptionFieldsProviderAllowNull(string $field): void
    {
        $this->expectNotToPerformAssertions();

        $request = $this->makeRequest(__DIR__.'/airlines.json', params: [
            $field => new IcaoIataCode(null, null),
        ]);
        $request->call();
    }
}
