<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockMovementRequest;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class StockMovementController extends Controller
{
    public function index(Request $request): View
    {
        $productId = $request->integer('product_id') ?: null;
        $type = $request->string('type')->toString() ?: null;

        $movements = StockMovement::with(['product.category', 'user'])
            ->search($request->string('search')->toString())
            ->product($productId)
            ->type($type)
            ->latest('moved_at')
            ->paginate(12)
            ->withQueryString();

        return view('stock-movements.index', [
            'movements' => $movements,
            'products' => Product::orderBy('name')->get(),
        ]);
    }

    public function create(Request $request): View
    {
        return view('stock-movements.create', [
            'products' => Product::active()->orderBy('name')->get(),
            'selectedProductId' => $request->integer('product_id') ?: null,
            'selectedType' => $request->string('type')->toString() ?: StockMovement::TYPE_IN,
        ]);
    }

    public function store(StockMovementRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated): void {
            $product = Product::lockForUpdate()->findOrFail($validated['product_id']);
            $quantity = (int) $validated['quantity'];
            $stockBefore = $product->quantity;
            $stockAfter = $validated['type'] === StockMovement::TYPE_IN
                ? $stockBefore + $quantity
                : $stockBefore - $quantity;

            if ($stockAfter < 0) {
                throw ValidationException::withMessages([
                    'quantity' => 'Stock out quantity cannot exceed the current stock.',
                ]);
            }

            $product->stockMovements()->create([
                'user_id' => auth()->id(),
                'type' => $validated['type'],
                'quantity' => $quantity,
                'stock_before' => $stockBefore,
                'stock_after' => $stockAfter,
                'unit_cost' => $validated['unit_cost'] ?? null,
                'reason' => $validated['reason'] ?? null,
                'reference' => $validated['reference'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'moved_at' => $validated['moved_at'] ?? now(),
            ]);

            $product->update(['quantity' => $stockAfter]);
        });

        return redirect()->route('stock-movements.index')->with('status', 'Stock movement recorded.');
    }
}
