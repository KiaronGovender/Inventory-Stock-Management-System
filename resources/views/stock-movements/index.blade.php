<x-app-layout title="Stock Movement">
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight text-slate-950">Stock movement</h1>
            <p class="mt-2 text-sm text-slate-600">Track stock in and stock out activity across products.</p>
        </div>
        <a href="{{ route('stock-movements.create') }}" class="rounded-md bg-teal-700 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-teal-800">Record movement</a>
    </div>

    <form method="GET" action="{{ route('stock-movements.index') }}" class="mb-4 grid gap-3 rounded-lg border border-slate-200 bg-white p-4 shadow-sm md:grid-cols-[minmax(0,1fr)_260px_160px_auto_auto]">
        <input type="search" name="search" value="{{ request('search') }}" placeholder="Search product, SKU, reason, reference"
            class="min-w-0 rounded-md border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-100">

        <select name="product_id" class="rounded-md border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-100">
            <option value="">All products</option>
            @foreach ($products as $product)
                <option value="{{ $product->id }}" @selected((string) request('product_id') === (string) $product->id)>{{ $product->sku }} - {{ $product->name }}</option>
            @endforeach
        </select>

        <select name="type" class="rounded-md border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-100">
            <option value="">All types</option>
            <option value="in" @selected(request('type') === 'in')>Stock in</option>
            <option value="out" @selected(request('type') === 'out')>Stock out</option>
        </select>

        <button type="submit" class="rounded-md border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-100">Filter</button>
        <a href="{{ route('stock-movements.index') }}" class="rounded-md px-4 py-2 text-center text-sm font-semibold text-slate-600 hover:bg-slate-100">Reset</a>
    </form>

    <section class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-5 py-3">Date</th>
                        <th class="px-5 py-3">Product</th>
                        <th class="px-5 py-3">Type</th>
                        <th class="px-5 py-3 text-right">Qty</th>
                        <th class="px-5 py-3 text-right">Before</th>
                        <th class="px-5 py-3 text-right">After</th>
                        <th class="px-5 py-3">Reference</th>
                        <th class="px-5 py-3">User</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($movements as $movement)
                        <tr>
                            <td class="px-5 py-4 text-slate-600">{{ $movement->moved_at->format('d M Y, H:i') }}</td>
                            <td class="px-5 py-4">
                                <a href="{{ route('products.show', $movement->product) }}" class="font-semibold text-slate-900 hover:text-teal-800">{{ $movement->product->name }}</a>
                                <div class="text-xs text-slate-500">{{ $movement->product->sku }}</div>
                            </td>
                            <td class="px-5 py-4">
                                <span class="rounded-full px-2 py-1 text-xs font-semibold {{ $movement->type === 'in' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                    {{ strtoupper($movement->type) }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-right font-semibold">{{ number_format($movement->quantity) }}</td>
                            <td class="px-5 py-4 text-right">{{ number_format($movement->stock_before) }}</td>
                            <td class="px-5 py-4 text-right">{{ number_format($movement->stock_after) }}</td>
                            <td class="px-5 py-4 text-slate-600">{{ $movement->reference ?: $movement->reason ?: 'None' }}</td>
                            <td class="px-5 py-4 text-slate-600">{{ $movement->user?->name ?: 'System' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-5 py-8 text-center text-slate-500">No stock movements found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <div class="mt-4">
        {{ $movements->links() }}
    </div>
</x-app-layout>
