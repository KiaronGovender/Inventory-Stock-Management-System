<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'Inventory') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 antialiased">
    @auth
        <div class="min-h-screen">
            <header class="border-b border-slate-200 bg-white">
                <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
                    <a href="{{ route('dashboard') }}" class="text-lg font-semibold tracking-tight text-slate-950">
                        Inventory Stock
                    </a>

                    <nav class="flex flex-wrap items-center gap-2 text-sm font-medium text-slate-600">
                        <a href="{{ route('dashboard') }}" class="rounded-md px-3 py-2 hover:bg-slate-100 hover:text-slate-950">Dashboard</a>
                        @if (Route::has('products.index'))
                            <a href="{{ route('products.index') }}" class="rounded-md px-3 py-2 hover:bg-slate-100 hover:text-slate-950">Products</a>
                        @endif
                        @if (Route::has('categories.index'))
                            <a href="{{ route('categories.index') }}" class="rounded-md px-3 py-2 hover:bg-slate-100 hover:text-slate-950">Categories</a>
                        @endif
                        @if (Route::has('stock-movements.index'))
                            <a href="{{ route('stock-movements.index') }}" class="rounded-md px-3 py-2 hover:bg-slate-100 hover:text-slate-950">Stock</a>
                        @endif
                    </nav>

                    <div class="flex items-center gap-3 text-sm">
                        <span class="text-slate-500">{{ auth()->user()->name }}</span>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="rounded-md border border-slate-300 px-3 py-2 font-medium text-slate-700 hover:bg-slate-100">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
                @if (session('status'))
                    <div class="mb-6 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                        {{ session('status') }}
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>
    @else
        <main class="flex min-h-screen items-center justify-center bg-slate-100 px-4 py-10">
            <div class="w-full max-w-md">
                {{ $slot }}
            </div>
        </main>
    @endauth
</body>
</html>
