<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\StockMovement;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StockMovement>
 */
class StockMovementFactory extends Factory
{
    public function definition(): array
    {
        $quantity = fake()->numberBetween(1, 25);

        return [
            'product_id' => Product::factory(),
            'user_id' => User::factory(),
            'type' => StockMovement::TYPE_IN,
            'quantity' => $quantity,
            'stock_before' => 0,
            'stock_after' => $quantity,
            'unit_cost' => fake()->randomFloat(2, 5, 1000),
            'reason' => fake()->randomElement(['Opening stock', 'Supplier delivery', 'Cycle count']),
            'reference' => strtoupper(fake()->bothify('REF-####')),
            'notes' => fake()->sentence(),
            'moved_at' => now(),
        ];
    }

    public function outbound(int $stockBefore = 10): static
    {
        $quantity = max(1, min($stockBefore, fake()->numberBetween(1, 5)));

        return $this->state(fn (): array => [
            'type' => StockMovement::TYPE_OUT,
            'quantity' => $quantity,
            'stock_before' => $stockBefore,
            'stock_after' => $stockBefore - $quantity,
        ]);
    }
}
