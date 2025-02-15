<?php

declare(strict_types=1);

namespace ChannelEngine;

use ChannelEngine\Contracts\ChannelEngineResponseInterface;
use Closure;
use JsonException;
use Traversable;

class ChannelEngineResponse implements ChannelEngineResponseInterface
{
    /**
     * @var array<int, array<string, mixed>>
     */
    public readonly array $data;

    protected Closure | null $parser = null;

    public function __construct(
        public readonly string $rawResponse,
    ) {
        $this->parseJson();
    }

    /**
     * @throws JsonException
     */
    protected function parseJson(): void
    {
        $this->data = json_decode($this->rawResponse, true, 512, JSON_THROW_ON_ERROR)['Content'];
    }

    public function setParser(Closure $parser): self
    {
        $this->parser = $parser;

        return $this;
    }

    public function getParsed(): Traversable
    {
        foreach ($this->data as $datum) {
            yield ($this->parser)($datum);
        }
    }
}
