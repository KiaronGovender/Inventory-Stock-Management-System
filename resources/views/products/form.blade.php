<form action="{{ $action }}" method="POST" class="space-y-6 rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    @if ($categories->isEmpty())
        <div class="rounded-md border border-amber-200 bg-amber-50 px-4 py-3 text-sm font-medium text-amber-800">
            Create a category before adding products.
        </div>
    @endif

    <div class="grid gap-5 md:grid-cols-2">
        <div>
            <label for="name" class="text-sm font-medium text-slate-700">Name</label>
            <input id="name" name="name" type="text" value="{{ old('name', $product->name) }}" required
                class="mt-2 w-full rounded-md border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-100">
            <x-input-error :messages="$errors->first('name')" />
        </div>

        <div>
            <label for="sku" class="text-sm font-medium text-slate-700">SKU</label>
            <input id="sku" name="sku" type="text" value="{{ old('sku', $product->sku) }}" required
                class="mt-2 w-full rounded-md border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-100">
            <x-input-error :messages="$errors->first('sku')" />
        </div>

        <div>
            <label for="category_id" class="text-sm font-medium text-slate-700">Category</label>
            <select id="category_id" name="category_id" required
                class="mt-2 w-full rounded-md border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-100">
                <option value="">Select category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected((string) old('category_id', $product->category_id) === (string) $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->first('category_id')" />
        </div>

        <div>
            <label for="unit" class="text-sm font-medium text-slate-700">Unit</label>
            <input id="unit" name="unit" type="text" value="{{ old('unit', $product->unit ?: 'pcs') }}" required
                class="mt-2 w-full rounded-md border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-100">
            <x-input-error :messages="$errors->first('unit')" />
        </div>

        <div>
            <label for="quantity" class="text-sm font-medium text-slate-700">Current stock</label>
            <input id="quantity" name="quantity" type="number" min="0" value="{{ old('quantity', $product->quantity ?? 0) }}" required
                class="mt-2 w-full rounded-md border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-100">
            <x-input-error :messages="$errors->first('quantity')" />
        </div>

        <div>
            <label for="low_stock_threshold" class="text-sm font-medium text-slate-700">Low-stock threshold</label>
            <input id="low_stock_threshold" name="low_stock_threshold" type="number" min="0" value="{{ old('low_stock_threshold', $product->low_stock_threshold ?? 5) }}" required
                class="mt-2 w-full rounded-md border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-100">
            <x-input-error :messages="$errors->first('low_stock_threshold')" />
        </div>

        <div>
            <label for="price" class="text-sm font-medium text-slate-700">Price</label>
            <input id="price" name="price" type="number" min="0" step="0.01" value="{{ old('price', $product->price ?? 0) }}" required
                class="mt-2 w-full rounded-md border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-100">
            <x-input-error :messages="$errors->first('price')" />
        </div>

        <label class="flex items-center gap-2 pt-8 text-sm font-medium text-slate-700">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product->is_active ?? true))
                class="rounded border-slate-300 text-teal-700 focus:ring-teal-600">
            Active product
        </label>
    </div>

    <div>
        <label for="description" class="text-sm font-medium text-slate-700">Description</label>
        <textarea id="description" name="description" rows="4"
            class="mt-2 w-full rounded-md border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-100">{{ old('description', $product->description) }}</textarea>
        <x-input-error :messages="$errors->first('description')" />
    </div>

    <div class="flex flex-wrap justify-end gap-2">
        <a href="{{ $product->exists ? route('products.show', $product) : route('products.index') }}" class="rounded-md px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100">Cancel</a>
        <button type="submit" @disabled($categories->isEmpty()) class="rounded-md bg-teal-700 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-teal-800 disabled:cursor-not-allowed disabled:bg-slate-300">Save product</button>
    </div>
</form>
