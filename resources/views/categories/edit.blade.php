<x-app-layout title="Edit Category">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold tracking-tight text-slate-950">Edit category</h1>
    </div>

    @include('categories.form', ['action' => route('categories.update', $category), 'method' => 'PUT'])
</x-app-layout>
