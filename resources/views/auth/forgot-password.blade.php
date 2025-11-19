<x-guest-layout>
    <x-slot name="logo">
        <a href="/">
            <h1 class="text-3xl font-bold text-green-600">AgriSmart</h1>
        </a>
    </x-slot>

    <div class="mb-4 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    {{-- Wrapper Putih --}}
    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                {{-- Tombol Submit Warna Hijau --}}
                <x-primary-button class="ms-3 bg-green-600 hover:bg-green-700">
                    {{ __('Email Password Reset Link') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>