<?php

use App\Models\Product;
use App\Models\User;
use App\Services\ProductService;
use Brick\Math\Exception\NumberFormatException;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

use function Pest\Laravel\actingAs;
uses()->group('products');

beforeEach(function () {
    $this->user = User::factory()->create();
});

function asAdmin():TestCase 
{
    $user = User::factory()->create(['is_admin' => true]);

    return test()->actingAs($user);
};

test('homepage contains empty table', function () {

    actingAs($this->user)
        ->get('/products')
        ->assertOk()
        ->assertSee(__('No products found'));
});

test('homepage contains non empty table', function () {

    $product = Product::factory()->create();

    actingAs($this->user)
        ->get('/products')
        ->assertOk()
        ->assertDontSee(__('No products found'))
        ->assertSeeText($product->name)
        ->assertSeeText($product->price)
        ->assertViewHas('products', function(LengthAwarePaginator $collection) use($product){
            return $collection->contains($product);
        });
});

test('product service create return product', function () {
    $product = (new ProductService())->create('table', 100);

    $this->assertInstanceOf(Product::class, $product);
});

test('product service create validation', function () {
   try {
    (new ProductService())->create('Too Big', 1999);
   } catch (\Exception $e) {
       $this->assertInstanceOf(NumberFormatException::class, $e);
   } 
});

test('paginated products does not contain 11th record', function () {

    $products = Product::factory(11)->create();
    $lastProduct = $products->last();
 
    actingAs($this->user)
        ->get('/products')
        ->assertStatus(200)
        ->assertViewHas('products', function (LengthAwarePaginator $collection) use ($lastProduct) {
            return $collection->doesntContain($lastProduct);
        });
});

test('admin can see add products', function () {
    asAdmin()
        ->get('/products')
        ->assertOk()
        ->assertSee('Add new product');
});

test('non admin can not see add products', function () {

    actingAs($this->user)
        ->get('/products')
        ->assertOk()
        ->assertDontSee('Add new product');
});

test('admin can access product create', function () {

    asAdmin()
        ->get('/products/create')
        ->assertOk()
        ->assertSee('Create product');
});

test('nonadmin cannot access product create', function () {

    actingAs($this->user)
        ->get('/products/create')
        ->assertForbidden();
});

// Using dataset
test('create a product successfully', function ($product) {

    asAdmin()
        ->post('/products', $product)
        ->assertStatus(302)
        ->assertRedirect('/products');

        $this->assertDatabaseHas('products', $product);

        $lastProduct = Product::latest()->first();
        expect($product['name'])->toBe($lastProduct->name)
            ->and($product['price'])->toBe($lastProduct->price);
})->with('products');

test('product edit contains correct values', function () {
    $product = Product::factory()->create();
 
    asAdmin()->get('products/' . $product->id . '/edit')
        ->assertStatus(200)
        ->assertSee('value="' . $product->name . '"', false) 
        ->assertSee('value="' . $product->price . '"', false); 
});

test('product update validation error redirects back to form', function () {
    $product = Product::factory()->create();
 
    asAdmin()->put('products/' . $product->id, [
        'name' => '',
        'price' => ''
    ])
        ->assertStatus(302)
        ->assertInvalid(['name', 'price'])
        ->assertSessionHasErrors(['name', 'price']); 
});

test('product delete successful', function () {
    $product = Product::factory()->create();
 
    asAdmin()
        ->delete('products/' . $product->id)
        ->assertStatus(302)
        ->assertRedirect('products');
 
    $this->assertDatabaseMissing('products', $product->toArray()); 
    $this->assertDatabaseCount('products', 0); 

    $this->assertModelMissing($product); 
    $this->assertDatabaseEmpty('products');
});