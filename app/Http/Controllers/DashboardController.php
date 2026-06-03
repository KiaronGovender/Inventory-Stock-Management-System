<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $lowStockProducts = Product::with('category')
            ->lowStock()
            ->orderBy('quantity')
            ->orderBy('name')
            ->limit(8)
            ->get();

        return view('dashboard', [
            'totalProducts' => Product::count(),
            'totalCategories' => Category::count(),
            'totalStock' => Product::sum('quantity'),
            'lowStockCount' => Product::lowStock()->count(),
            'stockInToday' => StockMovement::where('type', StockMovement::TYPE_IN)->whereDate('moved_at', now())->sum('quantity'),
            'stockOutToday' => StockMovement::where('type', StockMovement::TYPE_OUT)->whereDate('moved_at', now())->sum('quantity'),
            'lowStockProducts' => $lowStockProducts,
            'recentMovements' => StockMovement::with(['product.category', 'user'])
                ->latest('moved_at')
                ->limit(8)
                ->get(),
        ]);
    }
}
