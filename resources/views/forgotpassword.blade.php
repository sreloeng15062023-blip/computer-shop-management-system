<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in - Computer Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="h-screen w-full bg-cover bg-center flex items-center justify-end pr-10 lg:pr-20"
    style="background-image: url('{{ asset('images/pc.png') }}');">

    <!-- LOGIN CARD -->
    <div class="bg-white/90 backdrop-blur-md p-8 rounded-2xl shadow-2xl w-full max-w-sm text-center border border-white/50">

        <h2 class="text-2xl font-bold text-gray-800 mb-6">Sign in</h2>

        @if(session('error'))
        <div class="mb-4 p-2 bg-red-100 text-red-600 text-xs rounded-lg">
            {{ session('error') }}
        </div>
        @endif

        @if(session('success'))
        <div class="mb-4 p-2 bg-green-100 text-green-600 text-xs rounded-lg">
            {{ session('success') }}
        </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-4" autocomplete="off">
            @csrf

            <!-- Email Input -->
            <div class="relative">
                <input type="email" name="email" required autocomplete="off" placeholder="Email Address"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs text-gray-700 bg-gray-50/50">
                <i class="fa-regular fa-envelope absolute right-3 top-3 text-gray-400 text-xs"></i>
            </div>

            <!-- Password Input -->
            <div class="relative">
                <input type="password" name="password" required autocomplete="new-password" placeholder="Password"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs text-gray-700 bg-gray-50/50">
                <i class="fa-solid fa-lock absolute right-3 top-3 text-gray-400 text-xs"></i>
            </div>

            <!-- Forgot Password Link -->
            <div class="text-right">
                <a href="{{ route('forgotpassword') }}" class="text-[11px] text-blue-600 hover:underline font-medium">
                    ភ្លេចលេខសម្ងាត់?
                </a>
            </div>

            <!-- Login Button -->
            <button type="submit" class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs rounded-xl transition shadow-sm">
                Login
            </button>
        </form>

    </div>

</body>

</html>