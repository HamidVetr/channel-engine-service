<?php

declare(strict_types=1);

namespace ChannelEngine\Contracts;

use ChannelEngine\DataObjects\AbstractDataObject;
use Closure;
use Traversable;

interface ChannelEngineResponseInterface
{
    public function setParser(Closure $parser): self;

    /**
     * @return Traversable<AbstractDataObject>
     */
    public function getParsed(): Traversable;
}
