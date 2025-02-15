<?php

declare(strict_types=1);

namespace ChannelEngine\Contracts;

use ChannelEngine\DataObjects\GetOrdersRequestParametersDataObject;

interface ChannelEngineServiceInterface
{
    public function getOrders(GetOrdersRequestParametersDataObject $dto): ChannelEngineResponseInterface;
}
