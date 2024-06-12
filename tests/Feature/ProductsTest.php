<?php

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

use function Pest\Laravel\get;

test('homepage contains empty table', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    get('/products')
        ->assertStatus(200)
        ->assertSee(__('No products found'));
});

test('homepage contains non empty table', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $product = Product::create([
        'name' => 'table',
        'price' => 100,
    ]);

    get('/products')
        ->assertStatus(200)
        ->assertDontSee(__('No products found'))
        ->assertSeeText($product->name)
        ->assertSeeText($product->price)
        ->assertViewHas('products', function(Collection $collection) use($product){
            return $collection->contains($product);
        });
});