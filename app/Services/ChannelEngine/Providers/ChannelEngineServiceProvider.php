<?php

declare(strict_types=1);

namespace ChannelEngine\Providers;

use ChannelEngine\ChannelEngineClient;
use ChannelEngine\ChannelEngineService;
use ChannelEngine\Contracts\ChannelEngineClientInterface;
use ChannelEngine\Contracts\ChannelEngineServiceInterface;
use ChannelEngine\Contracts\Factories\ChannelEngineResponseFactoryInterface;
use ChannelEngine\Contracts\Factories\RequestFactoryInterface;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;

class ChannelEngineServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerServices()
            ->registerClients()
            ->registerCommands();
    }

    protected function registerServices(): self
    {
        $this->app->singleton(ChannelEngineServiceInterface::class, ChannelEngineService::class);

        return $this;
    }

    protected function registerClients(): self
    {
        $this->app->singleton(ChannelEngineClientInterface::class, function (Container $container) {
            return new ChannelEngineClient(
                new GuzzleClient(),
                $container->make(RequestFactoryInterface::class),
                $container->make(ChannelEngineResponseFactoryInterface::class),
            );
        });

        return $this;
    }

    protected function registerCommands(): self
    {
        $this->commands([
        ]);

        return $this;
    }
}
