<?php

declare(strict_types=1);

namespace Lsv\Airlabs;

use Psr\Http\Client\ClientInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\HttplugClient;

class RequestFactory
{
    public function __construct(
        #[\SensitiveParameter]
        private readonly string $apiKey,
        private ?ClientInterface $client = null
    ) {
    }

    public function call(RequestInterface $request): mixed
    {
        if (!$this->client) {
            $this->client = new HttplugClient(HttpClient::create());
        }

        $request->setClient($this->client);
        $request->setApiKey($this->apiKey);

        return $request->call();
    }
}
