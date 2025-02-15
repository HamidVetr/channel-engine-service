<?php

declare(strict_types=1);

namespace ChannelEngine\Console\Commands;

use ChannelEngine\DataObjects\GetOrdersRequestParametersDataObject;
use ChannelEngine\Enums\ChannelEngineOrderStatusesEnum;
use ChannelEngine\Jobs\GetOrdersJob;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Contracts\Bus\Dispatcher as JobDispatcher;
use Psr\Log\LoggerInterface;

class GetOrdersCommand extends Command
{
    public function __construct(
        protected LoggerInterface $logger,
    ) {
        parent::__construct();
    }

    /** @var string */
    protected $signature = 'channel-engine:get-orders {statuses}';

    /** @var string */
    protected $description = 'Get orders from Channel Engine API based on provided filters';

    public function handle(
        JobDispatcher $jobDispatcher,
    ): void {
        $dto = new GetOrdersRequestParametersDataObject(
            statuses: $this->statuses(),
        );

        try {
            $jobDispatcher->dispatch(new GetOrdersJob($dto));
        } catch (Exception $exception) {
            $this->logger->error($exception);
        }
    }

    protected function statuses(): array
    {
        return array_map(fn (string $status) => ChannelEngineOrderStatusesEnum::fromName($status), explode(',', $this->argument('statuses')));
    }
}
