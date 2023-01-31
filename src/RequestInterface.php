<?php

declare(strict_types=1);

namespace Lsv\Airlabs;

use Psr\Http\Client\ClientInterface;
use Symfony\Component\HttpFoundation\ParameterBag;

interface RequestInterface
{
    public function setClient(ClientInterface $client): void;

    public function setApiKey(#[\SensitiveParameter] string $apiKey): void;
    public function getQueryData(): ParameterBag;

    public function getRequest(): \Psr\Http\Message\RequestInterface;

    public function getResponse(): \Psr\Http\Message\ResponseInterface;

    public function call(): mixed;
}
