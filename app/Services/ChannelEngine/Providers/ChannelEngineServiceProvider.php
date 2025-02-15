<?php

declare(strict_types=1);

namespace ChannelEngine\Providers;

use ChannelEngine\ChannelEngineClient;
use ChannelEngine\ChannelEngineService;
use ChannelEngine\Console\Commands\GetOrdersCommand;
use ChannelEngine\Contracts\ChannelEngineClientInterface;
use ChannelEngine\Contracts\ChannelEngineServiceInterface;
use ChannelEngine\Contracts\Factories\ChannelEngineResponseFactoryInterface;
use ChannelEngine\Contracts\Factories\RequestFactoryInterface;
use ChannelEngine\Factories\ChannelEngineResponseFactory;
use ChannelEngine\Factories\RequestFactory;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;

class ChannelEngineServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerServices()
            ->registerClients()
            ->registerCommands()
            ->registerFactories();
    }

    protected function registerServices(): self
    {
        $this->app->singleton(ChannelEngineServiceInterface::class, ChannelEngineService::class);

        return $this;
    }

    protected function registerFactories(): self
    {
        $this->app->singleton(RequestFactoryInterface::class, function (Container $container) {
            $config = $container->make(Config::class);

            return new RequestFactory(
                apiKey : $config->get('channel-engine.api.key'),
                baseUri: $config->get('channel-engine.api.base_url') . '/' . $config->get('channel-engine.api.version'),
            );
        });

        $this->app->singleton(ChannelEngineResponseFactoryInterface::class, ChannelEngineResponseFactory::class);

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
            GetOrdersCommand::class,
        ]);

        return $this;
    }
}
