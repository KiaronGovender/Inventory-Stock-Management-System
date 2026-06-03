<x-app-layout title="New Product">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold tracking-tight text-slate-950">New product</h1>
    </div>

    @include('products.form', ['action' => route('products.store'), 'method' => 'POST'])
</x-app-layout>
