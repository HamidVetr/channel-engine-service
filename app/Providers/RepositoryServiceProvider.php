<?php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\Repositories\ProductRepositoryInterface;
use App\Repositories\ProductRepository;
use Wimski\ModelRepositories\Providers\ModelRepositoryServiceProvider;

class RepositoryServiceProvider extends ModelRepositoryServiceProvider
{
    protected array $repositories = [
        ProductRepositoryInterface::class => ProductRepository::class,
    ];
}
