<?php

declare(strict_types=1);

namespace ChannelEngine\Jobs;

use App\Contracts\Factories\ProductFactoryInterface;
use App\Exceptions\RequestException;
use ChannelEngine\Contracts\ChannelEngineServiceInterface;
use ChannelEngine\DataObjects\GetOrdersRequestParametersDataObject;
use ChannelEngine\DataObjects\OrderDataObject;
use ChannelEngine\DataObjects\OrderLineDataObject;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Psr\Log\LoggerInterface;

class GetOrdersJob implements ShouldBeUnique, ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly GetOrdersRequestParametersDataObject $dto,
    ) {
    }

    /**
     * @throws Exception
     */
    public function handle(
        ProductFactoryInterface $productFactory,
        ChannelEngineServiceInterface $channelEngineService,
        LoggerInterface $logger,
    ): void {
        try {
            $orders = $channelEngineService->getOrders($this->dto);

            /** @var OrderDataObject $order */
            foreach ($orders->getParsed() as $order) {
                $order->orderLines->each(function (OrderLineDataObject $orderLine) use ($productFactory) {
                    $productFactory->create(
                        originId: $orderLine->productId,
                        name    : $orderLine->productName,
                        gtin    : $orderLine->gtin,
                        quantity: $orderLine->quantity,
                    );
                });
            }
        } catch (RequestException $exception) {
            $logger->error($exception->getMessage(), $exception->getRequestData());

            throw new Exception($exception->getMessage());
        }
    }
}
