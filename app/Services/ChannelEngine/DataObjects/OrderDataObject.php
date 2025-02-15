<?php

declare(strict_types=1);

namespace ChannelEngine\DataObjects;

use ChannelEngine\Enums\ChannelEngineOrderStatusesEnum;
use Illuminate\Support\Collection;

class OrderDataObject extends AbstractDataObject
{
    /**
     * @param string $orderNumber
     * @param ChannelEngineOrderStatusesEnum $status
     * @param Collection<int, OrderLineDataObject> $orderLines
     */
    public function __construct(
        protected(set) string $orderNumber,
        protected(set) ChannelEngineOrderStatusesEnum $status,
        protected(set) Collection $orderLines,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'orderNumber' => $this->orderNumber,
            'status'      => $this->status->name,
            'orderLines'  => $this->orderLines->map(
                fn (OrderLineDataObject $orderLine) => $orderLine->toArray(),
            )->toArray(),
        ];
    }
}
