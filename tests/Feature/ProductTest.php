<?php

use App\Models\User;
use App\Models\Product;
use function Pest\Laravel\{actingAs, get};

test('la página de productos carga correctamente', function () {
    $user = User::factory()->create(); // crea usuario
    actingAs($user);                   // inicia sesión

    $response = get('/admin/products');
    $response->assertStatus(200);
});

test('un producto puede crearse', function () {
    $product = Product::factory()->create([
        'name' => 'Camisa de prueba',
    ]);

    expect($product->name)->toBe('Camisa de prueba');
});
