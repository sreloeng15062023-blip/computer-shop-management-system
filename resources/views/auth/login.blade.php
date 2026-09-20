<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-indigo-600 text-white font-bold text-2xl shadow-lg mb-2">
                    💻
                </div>
                <h1 class="text-2xl font-bold text-gray-900">Computer Shop System</h1>
                <p class="text-sm text-gray-500 mt-1">Management Portal (Topic 22)</p>
            </div>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email Address')" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />
                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-between mt-6">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @else
                    <span></span>
                @endif

                <x-button class="ml-3 bg-indigo-600 hover:bg-indigo-700">
                    {{ __('Sign In') }}
                </x-button>
            </div>
        </form>

        <!-- Quick-Fill Demo Buttons for Teacher & Testing -->
        <div class="mt-8 pt-6 border-t border-gray-200">
            <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-3 text-center">
                Demo Accounts (Password: <span class="font-mono text-gray-600">password123</span>):
            </p>
            <div class="grid grid-cols-3 gap-2">
                <button type="button" onclick="fillCredentials('admin@shop.com', 'password123')"
                    class="py-2 px-2 text-xs font-medium rounded-lg border border-gray-200 text-gray-700 bg-gray-50 hover:bg-indigo-50 hover:border-indigo-200 hover:text-indigo-600 transition">
                    👑 Admin
                </button>
                <button type="button" onclick="fillCredentials('cashier@shop.com', 'password123')"
                    class="py-2 px-2 text-xs font-medium rounded-lg border border-gray-200 text-gray-700 bg-gray-50 hover:bg-emerald-50 hover:border-emerald-200 hover:text-emerald-600 transition">
                    💳 Cashier
                </button>
                <button type="button" onclick="fillCredentials('tech@shop.com', 'password123')"
                    class="py-2 px-2 text-xs font-medium rounded-lg border border-gray-200 text-gray-700 bg-gray-50 hover:bg-amber-50 hover:border-amber-200 hover:text-amber-600 transition">
                    🔧 Tech
                </button>
            </div>
        </div>

        <script>
            function fillCredentials(email, password) {
                document.getElementById('email').value = email;
                document.getElementById('password').value = password;
            }
        </script>
    </x-auth-card>
</x-guest-layout>
