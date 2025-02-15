<?php

declare(strict_types=1);

namespace ChannelEngine;

use App\Enums\RequestMethodsEnum;
use App\Exceptions\RequestException;
use ChannelEngine\Contracts\ChannelEngineClientInterface;
use ChannelEngine\Contracts\ChannelEngineResponseInterface;
use ChannelEngine\Contracts\Factories\ChannelEngineResponseFactoryInterface;
use ChannelEngine\Contracts\Factories\RequestFactoryInterface;
use Exception;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ChannelEngineClient implements ChannelEngineClientInterface
{
    /**
     * @var array<string, string>
     */
    protected array $defaultHeaders = [];

    /**
     * @var array<string, mixed>
     */
    protected array $defaultOptions = [];

    public function __construct(
        protected ClientInterface $httpClient,
        protected RequestFactoryInterface $requestFactory,
        protected ChannelEngineResponseFactoryInterface $responseFactory,
    ) {
    }

    public function addHeader(string $headerName, string $headerValue): self
    {
        $this->defaultHeaders[$headerName] = $headerValue;

        return $this;
    }

    public function addOption(string $optionName, mixed $optionValue): self
    {
        $this->defaultOptions[$optionName] = $optionValue;

        return $this;
    }

    /**
     * @param array<string, string> $headers
     * @return array<string, string>
     */
    protected function addHeaders(array $headers = []): array
    {
        return array_merge($this->defaultHeaders, $headers);
    }

    /**
     * @param array<string, string> $options
     * @return array<string, string>
     */
    protected function addOptions(array $options = []): array
    {
        return array_merge($this->defaultOptions, $options);
    }

    public function get(
        string $uri,
        array $params = [],
        array $headers = [],
        array $options = [],
    ): ChannelEngineResponseInterface {
        return $this->makeRequest(RequestMethodsEnum::GET, $uri, $params, $headers, $options);
    }

    public function post(
        string $uri,
        array $body = [],
        array $headers = [],
        array $options = [],
    ): ChannelEngineResponseInterface {
        return $this->makeRequest(RequestMethodsEnum::POST, $uri, $body, $headers, $options);
    }

    /**
     * @param RequestMethodsEnum $method
     * @param string $uri
     * @param array<string, mixed> $data
     * @param array<string, string> $headers
     * @param array<string, mixed> $options
     * @return ChannelEngineResponseInterface
     * @throws RequestException
     * @throws GuzzleException
     */
    protected function makeRequest(
        RequestMethodsEnum $method,
        string $uri,
        array $data = [],
        array $headers = [],
        array $options = [],
    ): ChannelEngineResponseInterface {
        $headers = $this->addHeaders($headers);
        $options = $this->addOptions($options);

        $request = $this->requestFactory->make($uri, $method, $data, $headers);

        try {
            $response = $this->httpClient->send($request, $options);

            if ($response->getStatusCode() >= 400) {
                throw new HttpException(
                    $response->getStatusCode(),
                    (string) $response->getBody()
                );
            }
        } catch (Exception $exception) {
            throw new RequestException($request, $exception);
        }

        return $this->responseFactory->make($response);
    }
}
