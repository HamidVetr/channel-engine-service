<?php

declare(strict_types=1);

namespace Tests\Integration\Services\ChannelEngine\Console\Commands;

use ChannelEngine\ChannelEngineService;
use ChannelEngine\Contracts\ChannelEngineServiceInterface;
use ChannelEngine\Jobs\GetOrdersJob;
use Illuminate\Support\Facades\Bus;
use PHPUnit\Framework\Attributes\Test;
use Tests\Integration\AbstractIntegrationTestCase;
use Tests\Traits\MocksChannelEngineClient;

class GetOrdersCommandTest extends AbstractIntegrationTestCase
{
    use MocksChannelEngineClient;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app->instance(
            abstract: ChannelEngineServiceInterface::class,
            instance: new ChannelEngineService(
                $this->mockChannelEngineClient(),
            ),
        );
    }

    #[Test]
    public function it_dispatches_a_get_orders_job(): void
    {
        Bus::fake();

        $this->artisan('channel-engine:get-orders IN_PROGRESS');

        Bus::assertDispatched(GetOrdersJob::class);
    }
}
