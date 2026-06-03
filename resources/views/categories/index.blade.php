<x-app-layout title="Categories">
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight text-slate-950">Categories</h1>
            <p class="mt-2 text-sm text-slate-600">Group products for cleaner filtering and reporting.</p>
        </div>
        <a href="{{ route('categories.create') }}" class="rounded-md bg-teal-700 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-teal-800">New category</a>
    </div>

    <form method="GET" action="{{ route('categories.index') }}" class="mb-4 flex flex-col gap-3 rounded-lg border border-slate-200 bg-white p-4 shadow-sm sm:flex-row">
        <input type="search" name="search" value="{{ request('search') }}" placeholder="Search categories"
            class="min-w-0 flex-1 rounded-md border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-100">
        <button type="submit" class="rounded-md border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-100">Filter</button>
        <a href="{{ route('categories.index') }}" class="rounded-md px-4 py-2 text-center text-sm font-semibold text-slate-600 hover:bg-slate-100">Reset</a>
    </form>

    <section class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-5 py-3">Name</th>
                        <th class="px-5 py-3">Description</th>
                        <th class="px-5 py-3 text-right">Products</th>
                        <th class="px-5 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($categories as $category)
                        <tr>
                            <td class="px-5 py-4 font-semibold text-slate-900">{{ $category->name }}</td>
                            <td class="max-w-md px-5 py-4 text-slate-600">{{ $category->description ?: 'No description' }}</td>
                            <td class="px-5 py-4 text-right">{{ $category->products_count }}</td>
                            <td class="px-5 py-4">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('categories.edit', $category) }}" class="rounded-md border border-slate-300 px-3 py-1.5 font-semibold text-slate-700 hover:bg-slate-100">Edit</a>
                                    <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Delete this category?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-md border border-rose-200 px-3 py-1.5 font-semibold text-rose-700 hover:bg-rose-50">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-8 text-center text-slate-500">No categories found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <div class="mt-4">
        {{ $categories->links() }}
    </div>
</x-app-layout>
