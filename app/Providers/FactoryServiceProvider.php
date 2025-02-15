<?php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\Factories\ProductFactoryInterface;
use App\Factories\ProductFactory;
use Illuminate\Support\ServiceProvider;

class FactoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ProductFactoryInterface::class, ProductFactory::class);
    }
}
