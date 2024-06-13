<?php

namespace App\Services;

use App\Models\Product;
use Brick\Math\Exception\NumberFormatException;

class ProductService
{
    public function create(string $name, float $price): Product
    {
        if ($price > 1000) {
            throw new NumberFormatException('Price too high');
        }

        return Product::create([
            'name' => $name,
            'price' => $price,
        ]);
    }
}
