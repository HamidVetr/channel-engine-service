<?php

declare(strict_types=1);

namespace ChannelEngine;

use ChannelEngine\Contracts\ChannelEngineClientInterface;
use ChannelEngine\Contracts\ChannelEngineResponseInterface;
use ChannelEngine\Contracts\ChannelEngineServiceInterface;
use ChannelEngine\DataObjects\GetOrdersRequestParametersDataObject;
use ChannelEngine\DataObjects\OrderDataObject;
use ChannelEngine\DataObjects\OrderLineDataObject;
use ChannelEngine\Enums\ChannelEngineOrderStatusesEnum;

class ChannelEngineService implements ChannelEngineServiceInterface
{
    public function __construct(
        protected ChannelEngineClientInterface $client,
    ) {
    }

    public function getOrders(GetOrdersRequestParametersDataObject $dto): ChannelEngineResponseInterface
    {
        $response = $this->client->get(
            uri   : 'orders',
            params: [
                'statuses' => $dto->statuses,
            ],
        );

        $response->setParser(function ($item) {
            return new OrderDataObject(
                orderNumber: $item['ChannelOrderNo'],
                status     : ChannelEngineOrderStatusesEnum::fromName($item['Status']),
                orderLines : collect($item['Lines'])->map(function (array $line) {
                    return new OrderLineDataObject(
                        orderLineNumber: $line['ChannelOrderLineNo'],
                        productId      : $line['MerchantProductNo'],
                        productName    : $line['Description'],
                        gtin           : $line['Gtin'],
                        quantity       : $line['Quantity'],
                    );
                }),
            );
        });

        return $response;
    }
}
