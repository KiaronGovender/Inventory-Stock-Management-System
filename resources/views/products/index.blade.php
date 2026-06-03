<x-app-layout title="Products">
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight text-slate-950">Products</h1>
            <p class="mt-2 text-sm text-slate-600">Search products, filter by category, and monitor stock levels.</p>
        </div>
        <a href="{{ route('products.create') }}" class="rounded-md bg-teal-700 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-teal-800">New product</a>
    </div>

    <form method="GET" action="{{ route('products.index') }}" class="mb-4 grid gap-3 rounded-lg border border-slate-200 bg-white p-4 shadow-sm md:grid-cols-[minmax(0,1fr)_220px_180px_auto_auto]">
        <input type="search" name="search" value="{{ request('search') }}" placeholder="Search name, SKU, description"
            class="min-w-0 rounded-md border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-100">

        <select name="category_id" class="rounded-md border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-100">
            <option value="">All categories</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected((string) request('category_id') === (string) $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>

        <select name="status" class="rounded-md border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-100">
            <option value="">All statuses</option>
            <option value="low" @selected(request('status') === 'low')>Low stock</option>
            <option value="active" @selected(request('status') === 'active')>Active</option>
            <option value="inactive" @selected(request('status') === 'inactive')>Inactive</option>
        </select>

        <button type="submit" class="rounded-md border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-100">Filter</button>
        <a href="{{ route('products.index') }}" class="rounded-md px-4 py-2 text-center text-sm font-semibold text-slate-600 hover:bg-slate-100">Reset</a>
    </form>

    <section class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-5 py-3">Product</th>
                        <th class="px-5 py-3">Category</th>
                        <th class="px-5 py-3 text-right">Stock</th>
                        <th class="px-5 py-3 text-right">Threshold</th>
                        <th class="px-5 py-3 text-right">Price</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($products as $product)
                        <tr>
                            <td class="px-5 py-4">
                                <a href="{{ route('products.show', $product) }}" class="font-semibold text-slate-900 hover:text-teal-800">{{ $product->name }}</a>
                                <div class="text-xs text-slate-500">{{ $product->sku }}</div>
                            </td>
                            <td class="px-5 py-4 text-slate-600">{{ $product->category->name }}</td>
                            <td class="px-5 py-4 text-right font-semibold {{ $product->quantity <= $product->low_stock_threshold ? 'text-amber-700' : 'text-slate-900' }}">{{ number_format($product->quantity) }} {{ $product->unit }}</td>
                            <td class="px-5 py-4 text-right">{{ number_format($product->low_stock_threshold) }}</td>
                            <td class="px-5 py-4 text-right">R {{ number_format((float) $product->price, 2) }}</td>
                            <td class="px-5 py-4">
                                <div class="flex flex-wrap gap-1.5">
                                    <span class="rounded-full px-2 py-1 text-xs font-semibold {{ $product->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                        {{ $product->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                    @if ($product->quantity <= $product->low_stock_threshold)
                                        <span class="rounded-full bg-amber-100 px-2 py-1 text-xs font-semibold text-amber-700">Low</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('stock-movements.create', ['product_id' => $product->id]) }}" class="rounded-md border border-slate-300 px-3 py-1.5 font-semibold text-slate-700 hover:bg-slate-100">Stock</a>
                                    <a href="{{ route('products.edit', $product) }}" class="rounded-md border border-slate-300 px-3 py-1.5 font-semibold text-slate-700 hover:bg-slate-100">Edit</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-8 text-center text-slate-500">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
</x-app-layout>
