<?php

declare(strict_types=1);

namespace Tests\Traits;

use ChannelEngine\ChannelEngineClient;
use ChannelEngine\Factories\ChannelEngineResponseFactory;
use ChannelEngine\Factories\RequestFactory;

trait MocksChannelEngineClient
{
    use MocksHttpRequests;

    /**
     * @param string[]|null $overruledStubs
     * @return ChannelEngineClient
     */
    protected function mockChannelEngineClient(?array $overruledStubs = null): ChannelEngineClient
    {
        return new ChannelEngineClient(
            $this->getMockGuzzleClient($overruledStubs),
            new RequestFactory(
                apiKey : 'testapikey',
                baseUri: 'https://api-dev.channelengine.net/api/v2',
            ),
            new ChannelEngineResponseFactory(),
        );
    }
}
