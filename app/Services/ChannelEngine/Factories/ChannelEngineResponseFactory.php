<?php

declare(strict_types=1);

namespace ChannelEngine\Factories;

use ChannelEngine\ChannelEngineResponse;
use ChannelEngine\Contracts\ChannelEngineResponseInterface;
use ChannelEngine\Contracts\Factories\ChannelEngineResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;

class ChannelEngineResponseFactory implements ChannelEngineResponseFactoryInterface
{
    public function make(ResponseInterface $response): ChannelEngineResponseInterface
    {
        return new ChannelEngineResponse((string) $response->getBody());
    }
}
