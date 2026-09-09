<!-- ============================= AGRISMART PRELOADER ============================= -->
<div id="agrismart-preloader" class="fixed inset-0 z-[99999] flex flex-col items-center justify-center bg-white/95 backdrop-blur-md transition-all duration-500 ease-out">
    <div class="flex flex-col items-center text-center p-6 select-none">
        <!-- Logo with Spinning Ring -->
        <div class="relative flex items-center justify-center w-28 h-28 mb-5">
            <!-- Outer glowing pulse aura -->
            <div class="absolute inset-0 rounded-full bg-emerald-400/20 animate-ping" style="animation-duration: 2s;"></div>
            <!-- Spinning emerald ring -->
            <div class="absolute inset-0 rounded-full border-4 border-emerald-100 border-t-emerald-600 border-r-emerald-500 animate-spin" style="animation-duration: 1s;"></div>
            <!-- Center AgriSmart Emblem -->
            <div class="relative z-10 w-16 h-16 rounded-2xl bg-white shadow-md flex items-center justify-center p-2.5 border border-emerald-50">
                <img src="{{ asset('images/favicon.png') }}" alt="AgriSmart Emblem" class="w-full h-full object-contain">
            </div>
        </div>

        <!-- Brand Name & Animated Status -->
        <div class="space-y-1.5">
            <h3 class="text-xl font-extrabold tracking-tight text-slate-800">
                Agri<span class="text-emerald-600">Smart</span>
            </h3>
            <div class="flex items-center justify-center gap-1 text-xs font-semibold text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-100">
                <span>Memuat Perkebunan Cerdas</span>
                <span class="inline-flex">
                    <span class="animate-bounce" style="animation-delay: 0ms;">.</span>
                    <span class="animate-bounce" style="animation-delay: 150ms;">.</span>
                    <span class="animate-bounce" style="animation-delay: 300ms;">.</span>
                </span>
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        var preloader = document.getElementById('agrismart-preloader');
        if (!preloader) return;

        function hidePreloader() {
            if (!preloader || preloader.dataset.hidden === 'true') return;
            preloader.dataset.hidden = 'true';
            preloader.classList.add('opacity-0', 'pointer-events-none');
            setTimeout(function() {
                preloader.style.display = 'none';
            }, 550);
        }

        // Hide when page is fully loaded
        if (document.readyState === 'complete') {
            setTimeout(hidePreloader, 300);
        } else {
            window.addEventListener('load', function() {
                setTimeout(hidePreloader, 250);
            });
        }

        // Safety fallback: dismiss after max 2.2 seconds even if external assets hang
        setTimeout(hidePreloader, 2200);
    })();
</script>
