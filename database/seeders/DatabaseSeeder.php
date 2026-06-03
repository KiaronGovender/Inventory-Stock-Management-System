<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Inventory Admin',
            'email' => 'admin@example.com',
        ]);

        $categories = collect([
            ['name' => 'Electronics', 'description' => 'Devices, accessories, and small hardware.'],
            ['name' => 'Office Supplies', 'description' => 'Stationery and daily office consumables.'],
            ['name' => 'Warehouse', 'description' => 'Packing, storage, and dispatch materials.'],
            ['name' => 'Cleaning', 'description' => 'Cleaning products and facility supplies.'],
        ])->map(fn (array $category): Category => Category::create($category));

        $products = collect([
            ['Electronics', 'USB-C Cable', 'EL-USB-001', 18, 10, 89.99],
            ['Electronics', 'Wireless Mouse', 'EL-MOU-002', 6, 8, 249.00],
            ['Office Supplies', 'A4 Copy Paper', 'OS-PAP-003', 42, 20, 115.50],
            ['Office Supplies', 'Black Ballpoint Pens', 'OS-PEN-004', 4, 15, 2.99],
            ['Warehouse', 'Bubble Wrap Roll', 'WH-BUB-005', 12, 6, 149.99],
            ['Warehouse', 'Shipping Labels', 'WH-LAB-006', 35, 12, 79.00],
            ['Cleaning', 'Disinfectant 5L', 'CL-DIS-007', 3, 5, 189.00],
            ['Cleaning', 'Microfiber Cloths', 'CL-CLO-008', 28, 10, 12.50],
        ])->map(function (array $product) use ($categories): Product {
            [$categoryName, $name, $sku, $quantity, $threshold, $price] = $product;

            return Product::create([
                'category_id' => $categories->firstWhere('name', $categoryName)->id,
                'name' => $name,
                'sku' => $sku,
                'description' => "Seeded inventory item for {$categoryName}.",
                'unit' => 'pcs',
                'quantity' => $quantity,
                'low_stock_threshold' => $threshold,
                'price' => $price,
                'is_active' => true,
            ]);
        });

        $products->each(function (Product $product) use ($user): void {
            StockMovement::create([
                'product_id' => $product->id,
                'user_id' => $user->id,
                'type' => StockMovement::TYPE_IN,
                'quantity' => $product->quantity,
                'stock_before' => 0,
                'stock_after' => $product->quantity,
                'unit_cost' => $product->price,
                'reason' => 'Opening stock',
                'reference' => 'SEED-'.$product->sku,
                'notes' => 'Initial inventory seed.',
                'moved_at' => now()->subDays(rand(1, 10)),
            ]);
        });
    }
}
