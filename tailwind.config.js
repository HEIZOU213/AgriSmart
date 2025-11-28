/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],
    theme: {
        extend: {
            colors: {
                // Warna Primer (Hijau Segar - Tema Utama)
                "agritech-primary": {
                    50: "#f0fdf4",
                    100: "#dcfce7",
                    200: "#bbf7d0",
                    300: "#86efac",
                    400: "#4ade80",
                    500: "#22c55e", // DEFAULT
                    600: "#16a34a",
                    700: "#15803d",
                    800: "#166534",
                    900: "#14532d",
                    DEFAULT: "#22c55e",
                },

                // Warna Sekunder (Hijau Kebiruan - Komplementer)
                "agritech-secondary": {
                    50: "#ecfeff",
                    100: "#cffafe",
                    200: "#a5f3fc",
                    300: "#67e8f9",
                    400: "#22d3ee",
                    500: "#06b6d4", // DEFAULT
                    600: "#0891b2",
                    700: "#0e7490",
                    800: "#155e75",
                    900: "#164e63",
                    DEFAULT: "#06b6d4",
                },

                // Warna Aksen (Lime - Untuk Highlight)
                "agritech-accent": {
                    50: "#f7fee7",
                    100: "#ecfccb",
                    200: "#d9f99d",
                    300: "#bef264",
                    400: "#a3e635",
                    500: "#84cc16", // DEFAULT
                    600: "#65a30d",
                    700: "#4d7c0f",
                    800: "#3f6212",
                    900: "#365314",
                    DEFAULT: "#84cc16",
                },

                // Warna Netral (Slate - Untuk Teks & Background)
                "agritech-neutral": {
                    50: "#f8fafc",
                    100: "#f1f5f9",
                    200: "#e2e8f0",
                    300: "#cbd5e1",
                    400: "#94a3b8",
                    500: "#64748b",
                    600: "#475569",
                    700: "#334155",
                    800: "#1e293b",
                    900: "#0f172a",
                    DEFAULT: "#64748b",
                },

                // Alias untuk kemudahan penggunaan
                "agritech-bg": {
                    DEFAULT: "#f8fafc", // neutral-50
                    light: "#ffffff",
                    gray: "#f1f5f9", // neutral-100
                    dark: "#e2e8f0", // neutral-200
                },

                "agritech-text": {
                    DEFAULT: "#475569", // neutral-600
                    dark: "#1e293b", // neutral-800
                    light: "#64748b", // neutral-500
                    muted: "#94a3b8", // neutral-400
                },
            },
        },
    },
    plugins: [require("@tailwindcss/forms")],
};
