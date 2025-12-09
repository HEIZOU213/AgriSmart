<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator Access - AgriSmart</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>

{{-- Background Gelap untuk kesan "Secure" --}}
<body class="bg-slate-900 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-4xl flex bg-white rounded-3xl overflow-hidden shadow-2xl shadow-slate-900/50">
        
        {{-- BAGIAN KIRI: FORM (Clean & Minimalis) --}}
        <div class="w-full lg:w-1/2 p-8 md:p-12 flex flex-col justify-center relative">
            
            {{-- Badge Security --}}
            <div class="absolute top-8 left-8 flex items-center gap-2 text-slate-400 text-xs font-bold tracking-widest uppercase">
                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                <span>Restricted Area</span>
            </div>

            <div class="mt-8 mb-8">
                <h1 class="text-3xl font-extrabold text-slate-800">Admin Panel</h1>
                <p class="text-slate-500 mt-2 text-sm">Masuk untuk mengelola sistem AgriSmart.</p>
            </div>

            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-5">
                @csrf
                
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Email Administrator</label>
                    <input type="email" name="email" required 
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-slate-800 focus:border-slate-800 outline-none transition-all font-medium text-slate-800 placeholder-slate-400"
                        placeholder="admin@agrismart.id">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Security Key (Password)</label>
                    <input type="password" name="password" required 
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-slate-800 focus:border-slate-800 outline-none transition-all font-medium text-slate-800 placeholder-slate-400"
                        placeholder="••••••••••••">
                </div>

                <button type="submit" class="w-full py-3.5 bg-slate-900 text-white font-bold rounded-lg hover:bg-slate-800 transition-all flex items-center justify-center gap-2 shadow-lg shadow-slate-900/30">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                    <span>Akses Dashboard</span>
                </button>
            </form>

            <div class="mt-8 text-center">
                <a href="/" class="text-xs text-slate-400 hover:text-slate-600 transition-colors">← Kembali ke Halaman Utama</a>
            </div>
        </div>

        {{-- BAGIAN KANAN: Visualisasi Data / Server (Hanya di Desktop) --}}
        <div class="hidden lg:flex w-1/2 bg-slate-900 relative items-center justify-center p-12 overflow-hidden">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-20"></div>
            
            {{-- Efek Grid Cyberpunk --}}
            <div class="absolute inset-0 bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:24px_24px]"></div>

            <div class="relative z-10 text-center">
                <div class="w-20 h-20 bg-slate-800 rounded-2xl mx-auto flex items-center justify-center mb-6 border border-slate-700 shadow-2xl">
                    <svg class="w-10 h-10 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path></svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">Sistem Terpusat</h3>
                <p class="text-slate-400 text-sm leading-relaxed">
                    Pantau aktivitas user, kelola basis data pertanian, <br>dan keamanan sistem dari satu panel.
                </p>
            </div>
        </div>
    </div>

</body>
</html>