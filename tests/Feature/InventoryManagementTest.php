<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\User;

test('authenticated users can create categories and products', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('categories.store'), [
            'name' => 'Electronics',
            'description' => 'Device stock',
        ])
        ->assertRedirect(route('categories.index'));

    $category = Category::firstWhere('name', 'Electronics');

    $this->actingAs($user)
        ->post(route('products.store'), [
            'category_id' => $category->id,
            'sku' => 'EL-100',
            'name' => 'Wireless Keyboard',
            'description' => 'Compact keyboard',
            'unit' => 'pcs',
            'quantity' => 12,
            'low_stock_threshold' => 5,
            'price' => 399.99,
            'is_active' => '1',
        ])
        ->assertRedirect(route('products.index'));

    $this->assertDatabaseHas('products', [
        'sku' => 'EL-100',
        'quantity' => 12,
    ]);
});

test('stock movements update product quantities and prevent negative stock', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create(['quantity' => 10]);

    $this->actingAs($user)
        ->post(route('stock-movements.store'), [
            'product_id' => $product->id,
            'type' => StockMovement::TYPE_OUT,
            'quantity' => 4,
            'reason' => 'Customer order',
            'reference' => 'SO-100',
            'moved_at' => now()->format('Y-m-d H:i:s'),
        ])
        ->assertRedirect(route('stock-movements.index'));

    expect($product->fresh()->quantity)->toBe(6);

    $this->assertDatabaseHas('stock_movements', [
        'product_id' => $product->id,
        'type' => StockMovement::TYPE_OUT,
        'quantity' => 4,
        'stock_before' => 10,
        'stock_after' => 6,
    ]);

    $this->actingAs($user)
        ->from(route('stock-movements.create', ['product_id' => $product->id]))
        ->post(route('stock-movements.store'), [
            'product_id' => $product->id,
            'type' => StockMovement::TYPE_OUT,
            'quantity' => 99,
        ])
        ->assertRedirect(route('stock-movements.create', ['product_id' => $product->id]))
        ->assertSessionHasErrors('quantity');

    expect($product->fresh()->quantity)->toBe(6);
});

test('dashboard shows low stock products', function () {
    $user = User::factory()->create();
    $product = Product::factory()->lowStock()->create([
        'name' => 'Black Ballpoint Pens',
        'sku' => 'PEN-LOW',
    ]);

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertSee('Low-stock alerts')
        ->assertSee($product->name);
});
