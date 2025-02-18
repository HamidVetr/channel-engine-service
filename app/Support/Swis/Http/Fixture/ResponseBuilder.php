<?php

declare(strict_types=1);

namespace App\Support\Swis\Http\Fixture;

use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Swis\Http\Fixture\ResponseBuilder as OriginalResponseBuilder;

class ResponseBuilder extends OriginalResponseBuilder
{
    /**
     * @var array<string, string>|null
     */
    protected ?array $overruledStubs = null;

    public function __construct(
        string $fixturesPath,
        ResponseFactoryInterface | null $responseFactory = null,
        StreamFactoryInterface | null $streamFactory = null,
        protected readonly string | null $baseUri = null,
    ) {
        parent::__construct(
            $fixturesPath,
            $responseFactory,
            $streamFactory,
        );
    }

    /**
     * @param array<string, string> $overruledStubs
     * @return $this
     */
    public function setOverruledStubs(array $overruledStubs): self
    {
        $this->overruledStubs = $overruledStubs;

        return $this;
    }

    /**
     * @param RequestInterface $request
     * @param string $type
     * @return string[]
     */
    protected function getPossibleMockFilePathsForRequest(RequestInterface $request, string $type): array
    {
        $possiblePaths = parent::getPossibleMockFilePathsForRequest($request, $type);

        if (! $this->overruledStubs) {
            return $possiblePaths;
        }

        $basePath = implode('/', [
            $this->getFixturesPath(),
            $this->getHostFromRequest($request),
        ]);

        foreach ($possiblePaths as $possiblePath) {
            $possiblePath = str_replace($basePath, '', $possiblePath);
            $possiblePath = str_replace('.' . $type, '', $possiblePath);
            $possiblePath = trim($possiblePath, '/');

            if (array_key_exists($possiblePath, $this->overruledStubs)) {
                return [
                    $basePath . '/' . $this->overruledStubs[$possiblePath] . '.' . $type,
                ];
            }
        }

        return $possiblePaths;
    }

    protected function getHostFromRequest(RequestInterface $request): string
    {
        if ($this->baseUri !== null) {
            $request = $request->withUri(new Uri($this->baseUri));
        }

        return parent::getHostFromRequest($request);
    }
}
