<?php

declare(strict_types=1);

namespace Tests\Integration\Services\ChannelEngine;

use ChannelEngine\ChannelEngineService;
use ChannelEngine\Contracts\ChannelEngineClientInterface;
use ChannelEngine\Contracts\ChannelEngineResponseInterface;
use ChannelEngine\Contracts\ChannelEngineServiceInterface;
use ChannelEngine\DataObjects\GetOrdersRequestParametersDataObject;
use ChannelEngine\Enums\ChannelEngineOrderStatusesEnum;
use PHPUnit\Framework\Attributes\Test;
use Tests\Integration\AbstractIntegrationTestCase;
use Tests\Traits\MocksChannelEngineClient;

class ChannelEngineServiceTest extends AbstractIntegrationTestCase
{
    use MocksChannelEngineClient;

    protected ChannelEngineServiceInterface $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app->instance(ChannelEngineClientInterface::class, $this->mockChannelEngineClient());

        $this->service = new ChannelEngineService(
            $this->app->make(ChannelEngineClientInterface::class),
        );
    }

    #[Test]
    public function it_gets_all_orders(): void
    {
        $dto = new GetOrdersRequestParametersDataObject(
            statuses: [ChannelEngineOrderStatusesEnum::IN_PROGRESS],
        );

        $response = $this->service->getOrders($dto);

        $this->assertInstanceOf(ChannelEngineResponseInterface::class, $response);
    }

    #[Test]
    public function it_gets_a_product(): void
    {
        $response = $this->service->getProduct('1234');

        $this->assertInstanceOf(ChannelEngineResponseInterface::class, $response);
    }
}
