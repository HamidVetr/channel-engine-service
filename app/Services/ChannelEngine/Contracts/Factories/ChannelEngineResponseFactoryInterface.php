<?php

declare(strict_types=1);

namespace ChannelEngine\Contracts\Factories;

use ChannelEngine\Contracts\ChannelEngineResponseInterface;
use Psr\Http\Message\ResponseInterface;

interface ChannelEngineResponseFactoryInterface
{
    /**
     * @param ResponseInterface $response
     * @return ChannelEngineResponseInterface
     */
    public function make(ResponseInterface $response): ChannelEngineResponseInterface;
}
