<x-app-layout title="Register">
    <section class="rounded-lg border border-slate-200 bg-white p-8 shadow-sm">
        <div class="mb-8">
            <p class="text-sm font-semibold uppercase tracking-wide text-teal-700">Inventory Stock</p>
            <h1 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950">Create account</h1>
        </div>

        <form action="{{ route('register') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="text-sm font-medium text-slate-700">Name</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                    class="mt-2 w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-100">
                <x-input-error :messages="$errors->first('name')" />
            </div>

            <div>
                <label for="email" class="text-sm font-medium text-slate-700">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required
                    class="mt-2 w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-100">
                <x-input-error :messages="$errors->first('email')" />
            </div>

            <div>
                <label for="password" class="text-sm font-medium text-slate-700">Password</label>
                <input id="password" name="password" type="password" required
                    class="mt-2 w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-100">
                <x-input-error :messages="$errors->first('password')" />
            </div>

            <div>
                <label for="password_confirmation" class="text-sm font-medium text-slate-700">Confirm password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required
                    class="mt-2 w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-100">
            </div>

            <button type="submit" class="w-full rounded-md bg-teal-700 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-teal-800">
                Create account
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-slate-600">
            Already registered?
            <a href="{{ route('login') }}" class="font-semibold text-teal-700 hover:text-teal-900">Sign in</a>
        </p>
    </section>
</x-app-layout>
