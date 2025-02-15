<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Psr\Http\Message\RequestInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class RequestException extends Exception
{
    protected RequestInterface $request;

    /**
     * @param RequestInterface $request
     * @param Throwable        $exception
     */
    public function __construct(RequestInterface $request, Throwable $exception)
    {
        parent::__construct($exception->getMessage(), $exception->getCode(), $exception);

        $this->request = $request;
    }

    /**
     * @return array<string, mixed>
     */
    public function getRequestData(): array
    {
        return [
            'method'  => $this->request->getMethod(),
            'uri'     => (string) $this->request->getUri(),
            'headers' => $this->request->getHeaders(),
            'body'    => (string) $this->request->getBody(),
        ];
    }

    public function getStatusCode(): ?int
    {
        $previous = $this->getPrevious();

        if ($previous instanceof HttpException) {
            return $previous->getStatusCode();
        }

        return null;
    }
}
