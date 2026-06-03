<form action="{{ $action }}" method="POST" class="space-y-5 rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div>
        <label for="name" class="text-sm font-medium text-slate-700">Name</label>
        <input id="name" name="name" type="text" value="{{ old('name', $category->name) }}" required
            class="mt-2 w-full rounded-md border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-100">
        <x-input-error :messages="$errors->first('name')" />
    </div>

    <div>
        <label for="description" class="text-sm font-medium text-slate-700">Description</label>
        <textarea id="description" name="description" rows="4"
            class="mt-2 w-full rounded-md border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-100">{{ old('description', $category->description) }}</textarea>
        <x-input-error :messages="$errors->first('description')" />
    </div>

    <div class="flex flex-wrap justify-end gap-2">
        <a href="{{ route('categories.index') }}" class="rounded-md px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100">Cancel</a>
        <button type="submit" class="rounded-md bg-teal-700 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-teal-800">Save category</button>
    </div>
</form>
