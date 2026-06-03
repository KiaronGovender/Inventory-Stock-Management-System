<x-app-layout title="Record Stock">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold tracking-tight text-slate-950">Record stock movement</h1>
    </div>

    <form action="{{ route('stock-movements.store') }}" method="POST" class="space-y-6 rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        @csrf

        @if ($products->isEmpty())
            <div class="rounded-md border border-amber-200 bg-amber-50 px-4 py-3 text-sm font-medium text-amber-800">
                Add an active product before recording stock movement.
            </div>
        @endif

        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <label for="product_id" class="text-sm font-medium text-slate-700">Product</label>
                <select id="product_id" name="product_id" required
                    class="mt-2 w-full rounded-md border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-100">
                    <option value="">Select product</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" @selected((string) old('product_id', $selectedProductId) === (string) $product->id)>
                            {{ $product->sku }} - {{ $product->name }} ({{ $product->quantity }} {{ $product->unit }})
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->first('product_id')" />
            </div>

            <div>
                <label for="type" class="text-sm font-medium text-slate-700">Type</label>
                <select id="type" name="type" required
                    class="mt-2 w-full rounded-md border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-100">
                    <option value="in" @selected(old('type', $selectedType) === 'in')>Stock in</option>
                    <option value="out" @selected(old('type', $selectedType) === 'out')>Stock out</option>
                </select>
                <x-input-error :messages="$errors->first('type')" />
            </div>

            <div>
                <label for="quantity" class="text-sm font-medium text-slate-700">Quantity</label>
                <input id="quantity" name="quantity" type="number" min="1" value="{{ old('quantity', 1) }}" required
                    class="mt-2 w-full rounded-md border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-100">
                <x-input-error :messages="$errors->first('quantity')" />
            </div>

            <div>
                <label for="unit_cost" class="text-sm font-medium text-slate-700">Unit cost</label>
                <input id="unit_cost" name="unit_cost" type="number" min="0" step="0.01" value="{{ old('unit_cost') }}"
                    class="mt-2 w-full rounded-md border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-100">
                <x-input-error :messages="$errors->first('unit_cost')" />
            </div>

            <div>
                <label for="reason" class="text-sm font-medium text-slate-700">Reason</label>
                <input id="reason" name="reason" type="text" value="{{ old('reason') }}"
                    class="mt-2 w-full rounded-md border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-100">
                <x-input-error :messages="$errors->first('reason')" />
            </div>

            <div>
                <label for="reference" class="text-sm font-medium text-slate-700">Reference</label>
                <input id="reference" name="reference" type="text" value="{{ old('reference') }}"
                    class="mt-2 w-full rounded-md border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-100">
                <x-input-error :messages="$errors->first('reference')" />
            </div>

            <div>
                <label for="moved_at" class="text-sm font-medium text-slate-700">Movement date</label>
                <input id="moved_at" name="moved_at" type="datetime-local" value="{{ old('moved_at', now()->format('Y-m-d\TH:i')) }}"
                    class="mt-2 w-full rounded-md border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-100">
                <x-input-error :messages="$errors->first('moved_at')" />
            </div>
        </div>

        <div>
            <label for="notes" class="text-sm font-medium text-slate-700">Notes</label>
            <textarea id="notes" name="notes" rows="4"
                class="mt-2 w-full rounded-md border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-100">{{ old('notes') }}</textarea>
            <x-input-error :messages="$errors->first('notes')" />
        </div>

        <div class="flex flex-wrap justify-end gap-2">
            <a href="{{ route('stock-movements.index') }}" class="rounded-md px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100">Cancel</a>
            <button type="submit" @disabled($products->isEmpty()) class="rounded-md bg-teal-700 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-teal-800 disabled:cursor-not-allowed disabled:bg-slate-300">Record movement</button>
        </div>
    </form>
</x-app-layout>
