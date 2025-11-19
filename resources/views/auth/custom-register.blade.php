<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - AgriSmart</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
{{-- Padding vertical (py) dikurangi agar pas di layar kecil --}}
<body class="bg-gradient-to-br from-green-500 to-green-700 flex items-center justify-center min-h-screen py-4">

    {{-- Max-width diperlebar sedikit (max-w-lg) agar 2 kolom muat, padding dikurangi jadi p-6 --}}
    <div class="w-full max-w-lg bg-white p-6 rounded-lg shadow-2xl my-auto">
        
        <div class="text-center mb-4"> {{-- Margin bawah dikurangi --}}
            <h1 class="text-2xl font-bold text-green-600">AgriSmart</h1> {{-- Ukuran font dikurangi --}}
            <p class="text-gray-500 text-sm mt-1">Daftar sebagai Pembeli</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-2 rounded mb-3 text-xs border border-red-200">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            
            {{-- GRID LAYOUT: Mengubah form menjadi 2 kolom --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                
                {{-- Nama Lengkap --}}
                <div>
                    <label for="name" class="block text-gray-700 font-medium text-sm mb-1">Nama Lengkap</label>
                    <input type="text" name="name" id="name" class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-transparent" required>
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-gray-700 font-medium text-sm mb-1">Email</label>
                    <input type="email" name="email" id="email" class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-transparent" required>
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-gray-700 font-medium text-sm mb-1">Password</label>
                    <input type="password" name="password" id="password" class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-transparent" required>
                </div>

                {{-- Konfirmasi Password --}}
                <div>
                    <label for="password_confirmation" class="block text-gray-700 font-medium text-sm mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-transparent" required>
                </div>

            </div>

            {{-- Info Petani (Margin dikurangi) --}}
            <div class="mt-3 bg-blue-50 text-blue-700 p-2 rounded text-xs border border-blue-100 text-center">
                Ingin daftar sebagai <strong>Petani</strong>? Hubungi Admin.
            </div>

            <button type="submit" class="w-full mt-4 bg-green-600 text-white py-2 rounded hover:bg-green-700 transition duration-200 shadow-md text-sm font-bold">
                Daftar Sekarang
            </button>
        </form>

        <div class="mt-4 text-center text-xs">
            <p class="text-gray-600 inline">Sudah punya akun?</p>
            <a href="{{ route('login') }}" class="text-green-600 font-semibold hover:underline hover:text-green-700 ml-1">
                Masuk disini
            </a>
        </div>
    </div>

</body>
</html>