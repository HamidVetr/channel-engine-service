<?php

declare(strict_types=1);

namespace Tests\Traits;

use App\Support\Swis\Http\Fixture\ResponseBuilder;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use GuzzleHttp\HandlerStack;
use Psr\Http\Client\ClientInterface as PsrClientInterface;
use Swis\Guzzle\Fixture\Handler;
use Swis\Http\Fixture\Client as FixtureClient;
use Swis\Http\Fixture\MockNotFoundException;
use Throwable;

trait MocksHttpRequests
{
    use UsesStubs;

    /**
     * @param string[]|null $overruledStubs
     * @return PsrClientInterface
     */
    public function getMockPsrClient(?array $overruledStubs = null): PsrClientInterface
    {
        return new FixtureClient($this->createResponseBuilder($overruledStubs));
    }

    /**
     * @param string[]|null $overruledStubs
     * @return ResponseBuilder
     */
    protected function createResponseBuilder(
        ?array $overruledStubs = null,
        ?string $baseUri = null,
    ): ResponseBuilder {
        $responseBuilder = new ResponseBuilder(
            fixturesPath:  $this->getStubsPath('responses'),
            baseUri: $baseUri,
        );

        if ($overruledStubs) {
            $responseBuilder->setOverruledStubs($overruledStubs);
        }

        return $responseBuilder;
    }

    /**
     * @param string[]|null $overruledStubs
     * @return GuzzleClientInterface
     */
    public function getMockGuzzleClient(
        ?array $overruledStubs = null,
        ?string $baseUri = null,
    ): GuzzleClientInterface {
        $responseBuilder = $this->createResponseBuilder(
            $overruledStubs,
            $baseUri,
        );

        return new GuzzleClient([
            'handler' => HandlerStack::create(
                new Handler($responseBuilder),
            ),
        ]);
    }

    /**
     * @param Throwable $exception
     * @return string[]|null
     */
    public function getPossibleStubsFromException(Throwable $exception): ?array
    {
        if ($exception instanceof MockNotFoundException) {
            return $exception->getPossiblePaths();
        }

        $previous = $exception->getPrevious();

        if (! $previous) {
            return null;
        }

        return $this->getPossibleStubsFromException($previous);
    }
}
