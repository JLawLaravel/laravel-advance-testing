<?php

use App\Models\Product;

test('product price set successfully', function () {
    $product = Product::factory()->create([
        'name' => 'Product 1',
        'price' => 1.23
    ]);
    $this->assertEquals(123, $product->price);
});
