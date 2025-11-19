<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AgriSmart</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
{{-- [PERUBAHAN] Menggunakan Background Gradient Hijau agar sesuai tema --}}
<body class="bg-gradient-to-br from-green-500 to-green-700 flex items-center justify-center h-screen">

    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-2xl"> {{-- Shadow dipertebal --}}
        <div class="text-center mb-6">
            {{-- Logo --}}
            <h1 class="text-3xl font-bold text-green-600">AgriSmart</h1>
            <p class="text-gray-500 mt-2">Masuk ke akun Anda</p>
        </div>

        {{-- Pesan Error --}}
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm border border-red-200">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                <input type="email" name="email" id="email" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
            </div>

            <div class="mb-6">
                <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                <input type="password" name="password" id="password" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
            </div>

            <button type="submit" class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 transition duration-200 shadow-md">
                Masuk
            </button>
        </form>

        <div class="mt-6 text-center text-sm">
            <p class="text-gray-600">Belum punya akun?</p>
            <a href="{{ route('register') }}" class="text-green-600 font-semibold hover:underline hover:text-green-700">
                Daftar disini
            </a>
        </div>
    </div>

</body>
</html>