<?php

declare(strict_types=1);

namespace ChannelEngine\Contracts;

use ChannelEngine\DataObjects\GetOrdersRequestParametersDataObject;

interface ChannelEngineServiceInterface
{
    public function getOrders(GetOrdersRequestParametersDataObject $dto): ChannelEngineResponseInterface;

    public function getProduct(string $productId): ChannelEngineResponseInterface;

    // TODO:: improve by creating a method to update everything in the product including stock
    public function setProductStock(string $productId, int $stock): void;
}
