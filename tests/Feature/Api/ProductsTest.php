<?php

use App\Models\Product;

use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
// uses()->group('products');

// test('api returns products list', function () {
//     $product = Product::factory()->create();
 
//     $res = getJson('/api/products')
//         ->assertJson([$product->toArray()]);
 
//     expect($res->content())
//         ->json()
//         ->toHaveCount(1);
// });

// test('api product store successful', function () {
//     $product = [
//         'name' => 'Product 1',
//         'price' => 123
//     ];
 
//     postJson('/api/products', $product)
//         ->assertCreated()
//         ->assertSuccessful()
//         ->assertJson($product);
// });

// test('api product invalid store returns error', function () {
//     $product = [
//         'name' => '',
//         'price' => 123
//     ];
 
//     postJson('/api/products', $product)
//         ->assertUnprocessable()
//         ->assertJsonMissingValidationErrors('price')
//         ->assertInvalid('name');
// });

// test('api product show successful', function () {
//     $product = Product::factory()->create();

//     $this->getJson('/api/products/' . $product->id)
//         ->assertOk()
//         ->assertJsonPath('data.name', $product->name)
//         ->assertJsonMissingPath('data.created_at')
//         ->assertJsonStructure([
//             'data' => [
//                 'id',
//                 'name',
//                 'price'
//             ]
//         ]);

// });

// test('api product update successfully', function () {
//     $product = Product::factory()->create();

//     $this->putJson('api/products/' . $product->id, [
//         'name' => 'Product Updated',
//         'price' => 1234,
//     ])
//     ->assertOk()
//     ->assertJsonMissingPath($product);
// });

