<?php

declare(strict_types=1);

namespace App\Factories;

use App\Contracts\Factories\ProductFactoryInterface;
use App\Models\Product;

class ProductFactory implements ProductFactoryInterface
{
    public function create(
        string $originId,
        string $name,
        string $gtin,
        int $quantity,
    ): Product {
        $product = new Product([
            'origin_id' => $originId,
            'name'      => $name,
            'gtin'      => $gtin,
            'quantity'  => $quantity,
        ]);

        $product->save();

        return $product;
    }
}
