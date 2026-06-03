<x-app-layout title="Login">
    <section class="rounded-lg border border-slate-200 bg-white p-8 shadow-sm">
        <div class="mb-8">
            <p class="text-sm font-semibold uppercase tracking-wide text-teal-700">Inventory Stock</p>
            <h1 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950">Sign in</h1>
        </div>

        <form action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="text-sm font-medium text-slate-700">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                    class="mt-2 w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-100">
                <x-input-error :messages="$errors->first('email')" />
            </div>

            <div>
                <label for="password" class="text-sm font-medium text-slate-700">Password</label>
                <input id="password" name="password" type="password" required
                    class="mt-2 w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-100">
                <x-input-error :messages="$errors->first('password')" />
            </div>

            <label class="flex items-center gap-2 text-sm text-slate-600">
                <input type="checkbox" name="remember" value="1" class="rounded border-slate-300 text-teal-700 focus:ring-teal-600">
                Remember me
            </label>

            <button type="submit" class="w-full rounded-md bg-teal-700 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-teal-800">
                Sign in
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-slate-600">
            Need an account?
            <a href="{{ route('register') }}" class="font-semibold text-teal-700 hover:text-teal-900">Create one</a>
        </p>
    </section>
</x-app-layout>
