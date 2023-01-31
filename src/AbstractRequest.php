<?php

declare(strict_types=1);

namespace Lsv\Airlabs;

use Nyholm\Psr7\Request;
use Psr\Http\Client\ClientInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\HttplugClient;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Serializer\SerializerInterface;

#[\AllowDynamicProperties] abstract class AbstractRequest implements RequestInterface
{
    private const BASE_URL = 'https://airlabs.co/api/v9';
    protected ParameterBag $queryData;
    protected ParameterBag $resolvedQueryData;

    private ?ClientInterface $client = null;
    private ?string $apiKey = null;
    private ?SerializerInterface $serializer = null;
    protected bool $useFreePlan = false;

    public function __construct()
    {
        $this->queryData = new ParameterBag();
        $this->resolvedQueryData = new ParameterBag();
    }

    public function setClient(ClientInterface $client): void
    {
        $this->client = $client;
    }

    public function setApiKey(#[\SensitiveParameter] string $apiKey): void
    {
        $this->apiKey = $apiKey;
    }

    public function getQueryData(): ParameterBag
    {
        return $this->queryData;
    }

    public function getRequest(): \Psr\Http\Message\RequestInterface
    {
        if (!$this->apiKey) {
            throw new \RuntimeException('API key is not set, use "setApiKey" first.');
        }

        $queryResolver = new OptionsResolver();
        $this->validateQueryParameters($queryResolver);
        $this->resolvedQueryData->add($queryResolver->resolve($this->queryData->all()));
        $this->resolvedQueryData->set('api_key', $this->apiKey);

        $baseurl = sprintf('%s%s', self::BASE_URL, $this->getHttpUrl());
        $query = http_build_query($this->resolvedQueryData->all());
        $uri = sprintf('%s?%s', $baseurl, $query);

        return new Request(
            $this->getHttpMethod(),
            $uri
        );
    }

    public function getResponse(): \Psr\Http\Message\ResponseInterface
    {
        $client = $this->client ?? new HttplugClient(HttpClient::create());

        return $client->sendRequest($this->getRequest());
    }

    /**
     * @psalm-suppress MixedReturnStatement
     */
    protected function doCall(): mixed
    {
        return $this->setResponseData($this->getResponse());
    }

    abstract protected function validateQueryParameters(OptionsResolver $resolver): void;

    abstract protected function getHttpUrl(): string;

    /**
     * @return class-string<ResponseInterface>
     */
    abstract protected function getResponseClass(): string;

    /**
     * @infection-ignore-all
     */
    protected function responseIsArray(): bool
    {
        return true;
    }

    /**
     * @psalm-suppress MixedArrayAccess
     */
    private function setResponseData(\Psr\Http\Message\ResponseInterface $response): mixed
    {
        $body = json_decode($response->getBody()->getContents(), associative: true, flags: JSON_THROW_ON_ERROR);
        if (is_array($body) && isset($body['request']['key']['type'])) {
            $this->useFreePlan = 'free' === $body['request']['key']['type'];
        }

        if (!is_array($body) || !isset($body['response']) || !is_array($body['response'])) {
            throw new \RuntimeException('Could not get response from data');
        }
        $responseBody = $body['response'];

        $responseClass = sprintf('%s%s', $this->getResponseClass(), $this->responseIsArray() ? '[]' : '');

        $serializer = $this->serializer ?: Serializer\Serializer::create();

        return $serializer->deserialize(
            json_encode($responseBody),
            $responseClass,
            'json',
        );
    }

    private function getHttpMethod(): string
    {
        return 'GET';
    }
}
