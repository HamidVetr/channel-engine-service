<?php

declare(strict_types=1);

namespace App\Contracts\Factories;

use App\Models\Product;

interface ProductFactoryInterface
{
    public function create(
        string $originId,
        string $name,
        string $gtin,
        int $quantity,
    ): Product;
}
