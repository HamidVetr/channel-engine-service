<?php

declare(strict_types=1);

namespace ChannelEngine\DataObjects;

use ChannelEngine\Enums\ChannelEngineOrderStatusesEnum;

class GetOrdersRequestParametersDataObject extends AbstractDataObject
{
    public function __construct(
        protected(set) array $statuses {
            set {
                $this->statuses = array_map(
                    fn (ChannelEngineOrderStatusesEnum $status) => $status->name,
                    $value,
                );
            }
        },
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'statuses' => $this->statuses,
        ];
    }
}
