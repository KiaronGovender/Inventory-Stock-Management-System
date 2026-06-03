<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'sku' => strtoupper(fake()->unique()->bothify('SKU-####')),
            'name' => fake()->words(3, true),
            'description' => fake()->sentence(),
            'unit' => fake()->randomElement(['pcs', 'box', 'kg', 'litre']),
            'quantity' => fake()->numberBetween(0, 80),
            'low_stock_threshold' => fake()->numberBetween(5, 15),
            'price' => fake()->randomFloat(2, 10, 2500),
            'is_active' => true,
        ];
    }

    public function lowStock(): static
    {
        return $this->state(fn (): array => [
            'quantity' => 3,
            'low_stock_threshold' => 5,
        ]);
    }
}
