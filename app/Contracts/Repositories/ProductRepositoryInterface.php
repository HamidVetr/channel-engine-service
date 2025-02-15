<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use Illuminate\Support\Collection;

interface ProductRepositoryInterface
{
    // TODO:: improve by using a DTO
    public function orderBy(string $column, string $direction): Collection;
}
