<?php

use function Pest\Laravel\get;

test('unauthenticated user cannot access products', function () {
    get('/products')
        ->assertStatus(302)
        ->assertRedirect('/login');
});
