<?php

declare(strict_types=1);

namespace ChannelEngine\DataObjects;

class OrderLineDataObject extends AbstractDataObject
{
    public function __construct(
        protected(set) string $orderLineNumber,
        protected(set) string $productId,
        protected(set) string $productName,
        protected(set) string $gtin,
        protected(set) int $quantity,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'orderLineNumber' => $this->orderLineNumber,
            'productId'       => $this->productId,
            'productName'     => $this->productName,
            'gtin'            => $this->gtin,
            'quantity'        => $this->quantity,
        ];
    }
}
