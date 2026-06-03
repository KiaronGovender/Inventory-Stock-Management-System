<x-app-layout title="Dashboard">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight text-slate-950">Dashboard</h1>
            <p class="mt-2 text-sm text-slate-600">Monitor product counts, stock movement, and low-stock alerts.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('products.create') }}" class="rounded-md bg-teal-700 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-teal-800">New product</a>
            <a href="{{ route('stock-movements.create') }}" class="rounded-md border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-100">Record stock</a>
        </div>
    </div>

    <section class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Products</p>
            <p class="mt-2 text-3xl font-semibold tracking-tight">{{ number_format($totalProducts) }}</p>
        </div>
        <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Categories</p>
            <p class="mt-2 text-3xl font-semibold tracking-tight">{{ number_format($totalCategories) }}</p>
        </div>
        <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Units in stock</p>
            <p class="mt-2 text-3xl font-semibold tracking-tight">{{ number_format($totalStock) }}</p>
        </div>
        <a href="{{ route('products.index', ['status' => 'low']) }}" class="rounded-lg border border-amber-200 bg-amber-50 p-5 shadow-sm hover:border-amber-300">
            <p class="text-sm font-medium text-amber-700">Low-stock alerts</p>
            <p class="mt-2 text-3xl font-semibold tracking-tight text-amber-900">{{ number_format($lowStockCount) }}</p>
        </a>
    </section>

    <section class="mt-8 grid gap-6 lg:grid-cols-2">
        <div class="rounded-lg border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
                <h2 class="text-base font-semibold text-slate-950">Low stock</h2>
                <a href="{{ route('products.index', ['status' => 'low']) }}" class="text-sm font-semibold text-teal-700 hover:text-teal-900">View all</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                        <tr>
                            <th class="px-5 py-3">Product</th>
                            <th class="px-5 py-3">Category</th>
                            <th class="px-5 py-3 text-right">Stock</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($lowStockProducts as $product)
                            <tr>
                                <td class="px-5 py-4">
                                    <a href="{{ route('products.show', $product) }}" class="font-semibold text-slate-900 hover:text-teal-800">{{ $product->name }}</a>
                                    <div class="text-xs text-slate-500">{{ $product->sku }}</div>
                                </td>
                                <td class="px-5 py-4 text-slate-600">{{ $product->category->name }}</td>
                                <td class="px-5 py-4 text-right font-semibold text-amber-700">{{ $product->quantity }} / {{ $product->low_stock_threshold }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-5 py-8 text-center text-slate-500">No low-stock products.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="rounded-lg border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
                <h2 class="text-base font-semibold text-slate-950">Recent movement</h2>
                <a href="{{ route('stock-movements.index') }}" class="text-sm font-semibold text-teal-700 hover:text-teal-900">View all</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                        <tr>
                            <th class="px-5 py-3">Product</th>
                            <th class="px-5 py-3">Type</th>
                            <th class="px-5 py-3 text-right">Qty</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($recentMovements as $movement)
                            <tr>
                                <td class="px-5 py-4">
                                    <a href="{{ route('products.show', $movement->product) }}" class="font-semibold text-slate-900 hover:text-teal-800">{{ $movement->product->name }}</a>
                                    <div class="text-xs text-slate-500">{{ $movement->moved_at->format('d M Y, H:i') }}</div>
                                </td>
                                <td class="px-5 py-4">
                                    <span class="rounded-full px-2 py-1 text-xs font-semibold {{ $movement->type === 'in' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                        {{ strtoupper($movement->type) }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-right font-semibold">{{ $movement->quantity }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-5 py-8 text-center text-slate-500">No stock movement yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <section class="mt-6 grid gap-4 sm:grid-cols-2">
        <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Stock in today</p>
            <p class="mt-2 text-2xl font-semibold text-emerald-700">{{ number_format($stockInToday) }}</p>
        </div>
        <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Stock out today</p>
            <p class="mt-2 text-2xl font-semibold text-rose-700">{{ number_format($stockOutToday) }}</p>
        </div>
    </section>
</x-app-layout>
