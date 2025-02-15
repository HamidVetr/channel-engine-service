<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Support\Collection;
use Wimski\ModelRepositories\Repositories\AbstractModelRepository;

/**
 * @extends AbstractModelRepository<Product>
 */
class ProductRepository extends AbstractModelRepository implements ProductRepositoryInterface
{
    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function orderBy(
        string $column,
        string $direction,
    ): Collection
    {
        return $this->builder()
            ->orderBy($column, $direction)
            ->get();
    }
}
