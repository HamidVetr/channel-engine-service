<?php

declare(strict_types=1);

namespace Tests\Integration\Services\ChannelEngine\Jobs;

use App\Contracts\Factories\ProductFactoryInterface;
use ChannelEngine\ChannelEngineService;
use ChannelEngine\Contracts\ChannelEngineServiceInterface;
use ChannelEngine\DataObjects\GetOrdersRequestParametersDataObject;
use ChannelEngine\Enums\ChannelEngineOrderStatusesEnum;
use ChannelEngine\Jobs\GetOrdersJob;
use PHPUnit\Framework\Attributes\Test;
use Psr\Log\LoggerInterface;
use Tests\Integration\AbstractIntegrationTestCase;
use Tests\Traits\MocksChannelEngineClient;

class GetOrdersJobTest extends AbstractIntegrationTestCase
{
    use MocksChannelEngineClient;

    #[Test]
    public function it_fetches_orders_and_processes_them(): void
    {
        $this->app->instance(
            abstract: ChannelEngineServiceInterface::class,
            instance: new ChannelEngineService(
                $this->mockChannelEngineClient(),
            ),
        );

        $dto = new GetOrdersRequestParametersDataObject(
            statuses: [ChannelEngineOrderStatusesEnum::IN_PROGRESS],
        );

        $job = new GetOrdersJob($dto);

        $job->handle(
            $this->app->make(ProductFactoryInterface::class),
            $this->app->make(ChannelEngineServiceInterface::class),
            $this->app->make(LoggerInterface::class),
        );

        $this->assertDatabaseCount(table: 'products', count: 3);

        $this->assertDatabaseHas(
            table: 'products',
            data : [
                'origin_id' => 'PROD_SKU_ZESZ_SKOROWIDZ_1',
                'name'      => 'Skorowidz TOP-2000 Color A5 96 kartek w kratkę, Niebieski',
                'gtin'      => '5904017377016',
                'quantity'  => 2,
            ],
        );

        $this->assertDatabaseHas(
            table: 'products',
            data : [
                'origin_id' => 'PROD_SKU_KALENDARZ_111',
                'name'      => 'KALENDARZ TRÓJDZIELNY 2025 TOP 2000 MIX 31X70,5 CM',
                'gtin'      => '5901466243596',
                'quantity'  => 1,
            ],
        );

        $this->assertDatabaseHas(
            table: 'products',
            data : [
                'origin_id' => 'PROD_SKU_ZESZ_SKOROWIDZ_1',
                'name'      => 'Skorowidz TOP-2000 Color A5 96 kartek w kratkę, Niebieski',
                'gtin'      => '5904017377016',
                'quantity'  => 1,
            ],
        );
    }
}
