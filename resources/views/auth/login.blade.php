<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in - Computer Shop Management System</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="h-screen w-full bg-cover bg-center flex items-center justify-end pr-8 sm:pr-14 lg:pr-24"
    style="background-image: url('{{ asset('images/pc.png') }}');">

    <!-- LOGIN CARD -->
    <div class="bg-white/95 backdrop-blur-md p-8 rounded-2xl shadow-2xl w-full max-w-sm text-center border border-white/60">

        <!-- Logo Icon & Title -->
        <div class="mb-4">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-blue-600 text-white text-xl shadow-md mb-2">
                <i class="fa-solid fa-desktop"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800">Sign in</h2>
            <p class="text-xs text-gray-500 mt-1">Computer Shop Management System</p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
        <div class="mb-4 p-2.5 bg-blue-50 border border-blue-200 text-blue-700 text-xs rounded-xl text-left">
            {{ session('status') }}
        </div>
        @endif

        <!-- Validation Errors Display -->
        {{-- If the user leaves the email empty or types an invalid format (e.g. abc),
         Laravel stops execution immediately and redirects back to the login page with an error message. --}}
        @if ($errors->any())
        <div class="mb-4 p-2.5 bg-red-50 border border-red-200 text-red-600 text-xs rounded-xl text-left">
            <i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $errors->first() }}
        </div>
        @endif

        <!-- Login Form -->
        <form action="{{ route('login') }}" method="POST" class="space-y-3.5" autocomplete="off">
            @csrf

            <!-- Email Address Input -->
            <div class="relative text-left">
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="off" placeholder="Email Address"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs text-gray-700 bg-gray-50/50">
                <i class="fa-regular fa-envelope absolute right-3.5 top-3.5 text-gray-400 text-xs"></i>
            </div>

            <!-- Password Input -->
            <div class="relative text-left">
                <input type="password" id="password" name="password" required autocomplete="current-password" placeholder="Password"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs text-gray-700 bg-gray-50/50">
                <i class="fa-solid fa-lock absolute right-3.5 top-3.5 text-gray-400 text-xs"></i>
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between text-[11px] text-gray-500 pt-1">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 text-xs">
                    <span class="ml-1.5">Remember me</span>
                </label>
                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="hover:text-blue-600 hover:underline">Forgot password?</a>
                @endif
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs rounded-xl transition shadow-md hover:shadow-lg">
                Sign In
            </button>
        </form>

        <!-- Social Platform Buttons -->
        <div class="mt-6 pt-4 border-t border-gray-200">
            <p class="text-[11px] text-gray-400 mb-2">or login with social platform</p>
            <div class="flex justify-center items-center gap-3">
                <a href="{{ route('social.login', 'google') }}" class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center text-gray-700 hover:bg-red-50 hover:border-red-500 transition">
                    <i class="fa-brands fa-google text-xs text-red-500"></i>
                </a>
                <a href="{{ route('social.login', 'facebook') }}" class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center text-gray-700 hover:bg-blue-50 hover:border-blue-500 transition">
                    <i class="fa-brands fa-facebook-f text-xs text-blue-600"></i>
                </a>
                <a href="{{ route('social.login', 'telegram') }}" class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center text-gray-700 hover:bg-sky-50 hover:border-sky-500 transition">
                    <i class="fa-brands fa-telegram text-xs text-sky-500"></i>
                </a>
            </div>
        </div>

        <div class="mt-5 text-xs text-gray-600">
            Don't have an account? <a href="{{ route('register') }}" class="text-blue-600 font-semibold hover:underline">Register</a>
        </div>

    </div>
</body>

</html>
