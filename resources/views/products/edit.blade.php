<x-app-layout title="Edit Product">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold tracking-tight text-slate-950">Edit product</h1>
    </div>

    @include('products.form', ['action' => route('products.update', $product), 'method' => 'PUT'])
</x-app-layout>
