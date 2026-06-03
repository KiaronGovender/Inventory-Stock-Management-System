<x-app-layout title="{{ $product->name }}">
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight text-slate-950">{{ $product->name }}</h1>
            <p class="mt-2 text-sm text-slate-600">{{ $product->sku }} in {{ $product->category->name }}</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('stock-movements.create', ['product_id' => $product->id, 'type' => 'in']) }}" class="rounded-md bg-teal-700 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-teal-800">Stock in</a>
            <a href="{{ route('stock-movements.create', ['product_id' => $product->id, 'type' => 'out']) }}" class="rounded-md border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-100">Stock out</a>
            <a href="{{ route('products.edit', $product) }}" class="rounded-md border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-100">Edit</a>
        </div>
    </div>

    @if ($product->quantity <= $product->low_stock_threshold)
        <div class="mb-6 rounded-md border border-amber-200 bg-amber-50 px-4 py-3 text-sm font-medium text-amber-800">
            Low-stock alert: {{ $product->quantity }} {{ $product->unit }} available, threshold is {{ $product->low_stock_threshold }}.
        </div>
    @endif

    <section class="grid gap-4 md:grid-cols-4">
        <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Current stock</p>
            <p class="mt-2 text-3xl font-semibold tracking-tight">{{ number_format($product->quantity) }}</p>
        </div>
        <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Threshold</p>
            <p class="mt-2 text-3xl font-semibold tracking-tight">{{ number_format($product->low_stock_threshold) }}</p>
        </div>
        <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Unit</p>
            <p class="mt-2 text-3xl font-semibold tracking-tight">{{ $product->unit }}</p>
        </div>
        <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Price</p>
            <p class="mt-2 text-3xl font-semibold tracking-tight">R {{ number_format((float) $product->price, 2) }}</p>
        </div>
    </section>

    <section class="mt-6 rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
        <h2 class="text-base font-semibold text-slate-950">Details</h2>
        <p class="mt-3 text-sm leading-6 text-slate-600">{{ $product->description ?: 'No description recorded.' }}</p>
    </section>

    <section class="mt-6 overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
        <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
            <h2 class="text-base font-semibold text-slate-950">Stock history</h2>
            <a href="{{ route('stock-movements.index', ['product_id' => $product->id]) }}" class="text-sm font-semibold text-teal-700 hover:text-teal-900">View all</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-5 py-3">Date</th>
                        <th class="px-5 py-3">Type</th>
                        <th class="px-5 py-3 text-right">Qty</th>
                        <th class="px-5 py-3 text-right">Before</th>
                        <th class="px-5 py-3 text-right">After</th>
                        <th class="px-5 py-3">User</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($movements as $movement)
                        <tr>
                            <td class="px-5 py-4 text-slate-600">{{ $movement->moved_at->format('d M Y, H:i') }}</td>
                            <td class="px-5 py-4">
                                <span class="rounded-full px-2 py-1 text-xs font-semibold {{ $movement->type === 'in' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                    {{ strtoupper($movement->type) }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-right font-semibold">{{ $movement->quantity }}</td>
                            <td class="px-5 py-4 text-right">{{ $movement->stock_before }}</td>
                            <td class="px-5 py-4 text-right">{{ $movement->stock_after }}</td>
                            <td class="px-5 py-4 text-slate-600">{{ $movement->user?->name ?: 'System' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-8 text-center text-slate-500">No stock history yet.</td>
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
