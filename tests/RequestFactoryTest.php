<?php

declare(strict_types=1);

namespace Lsv\AirlabsTests;

use Lsv\Airlabs\RequestFactory;
use Lsv\Airlabs\RequestInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;

class RequestFactoryTest extends TestCase
{
    public function testFactory(): void
    {
        $client = $this->createMock(ClientInterface::class);
        $request = $this->createMock(RequestInterface::class);
        $request
            ->expects($this->once())
            ->method('setClient')
            ->with($client);
        $request
            ->expects($this->once())
            ->method('setApiKey')
            ->with('apikey');

        $factory = new RequestFactory('apikey', $client);
        $factory->call($request);
    }

    public function testFactoryNoClient(): void
    {
        $request = $this->createMock(RequestInterface::class);
        $request
            ->expects($this->once())
            ->method('setClient');
        $request
            ->expects($this->once())
            ->method('setApiKey')
            ->with('apikey');

        $factory = new RequestFactory('apikey');
        $factory->call($request);
    }
}
