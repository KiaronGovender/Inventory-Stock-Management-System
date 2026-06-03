<x-app-layout title="New Category">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold tracking-tight text-slate-950">New category</h1>
    </div>

    @include('categories.form', ['action' => route('categories.store'), 'method' => 'POST'])
</x-app-layout>
