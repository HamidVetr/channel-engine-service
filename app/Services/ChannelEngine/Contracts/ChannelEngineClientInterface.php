<?php

declare(strict_types=1);

namespace ChannelEngine\Contracts;

interface ChannelEngineClientInterface
{
    /**
     * @param string $uri
     * @param array<string, mixed> $params
     * @param array<string, string> $headers
     * @param array<string, mixed> $options
     * @return ChannelEngineResponseInterface
     */
    public function get(
        string $uri,
        array $params = [],
        array $headers = [],
        array $options = [],
    ): ChannelEngineResponseInterface;

    /**
     * @param string $uri
     * @param array<string, mixed> $body
     * @param array<string, string> $headers
     * @param array<string, mixed> $options
     * @return ChannelEngineResponseInterface
     */
    public function post(
        string $uri,
        array $body = [],
        array $headers = [],
        array $options = [],
    ): ChannelEngineResponseInterface;

    public function addHeader(string $headerName, string $headerValue): self;

    public function addOption(string $optionName, mixed $optionValue): self;
}
