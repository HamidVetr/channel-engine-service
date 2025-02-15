<?php

declare(strict_types=1);

namespace ChannelEngine;

use ChannelEngine\Contracts\ChannelEngineResponseInterface;

class ChannelEngineResponse implements ChannelEngineResponseInterface
{
    public function __construct(
        protected(set) string $rawResponse {
            get {
                return $this->rawResponse;
            }
        },
    ) {
    }

}
