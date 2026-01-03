<button id="backToTop" aria-label="Kembali ke atas" {{ $attributes->merge(['class' => 'fixed bottom-6 right-4 sm:bottom-8 sm:right-8 bg-green-600 hover:bg-green-700 text-white p-2.5 sm:p-3 rounded-xl translate-y-20 opacity-0 transition-all duration-500 z-50']) }}>
    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
    </svg>
</button>

<script>
    // Gunakan DOMContentLoaded agar script jalan setelah HTML siap
    document.addEventListener('DOMContentLoaded', () => {
        const backToTopBtn = document.getElementById('backToTop');

        if (backToTopBtn) {
            window.addEventListener('scroll', () => {
                if (window.scrollY > 300) {
                    backToTopBtn.classList.remove('translate-y-20', 'opacity-0');
                } else {
                    backToTopBtn.classList.add('translate-y-20', 'opacity-0');
                }
            });

            backToTopBtn.addEventListener('click', () => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }
    });
</script>