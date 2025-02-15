<?php

declare(strict_types=1);

namespace ChannelEngine\Factories;

use App\Enums\RequestMethodsEnum;
use ChannelEngine\Contracts\Factories\RequestFactoryInterface;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

class RequestFactory implements RequestFactoryInterface
{
    public function __construct(
        protected string $apiKey,
        protected string $baseUri {
            set {
                $this->baseUri = rtrim($value, '/');
            }
        },
    ) {
    }

    public function make(
        string $uri,
        RequestMethodsEnum $method,
        array $data = [],
        array $headers = [],
    ): RequestInterface {
        return new Request(
            $method->name,
            $this->makeUri($uri, $method, $data),
            $headers,
            $method === RequestMethodsEnum::GET ? null : json_encode($data),
        );
    }

    public function makeUri(string $uri, RequestMethodsEnum $method, array $data = []): string
    {
        // If $uri is not an absolute url, prepend it with the base url property
        if (preg_match('/^https?:\/\//', $uri) !== 1) {
            $uri = $this->baseUri . '/' . trim($uri, '/');
        }

        if ($method !== RequestMethodsEnum::GET) {
            return $uri . '?' . http_build_query(['apiKey' => $this->apiKey]);
        }

        $data['apiKey'] = $this->apiKey;

        return $uri . '?' . http_build_query($data);
    }
}
