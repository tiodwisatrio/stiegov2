import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.js", // Tambahkan kalau ada Alpine/JS yang bikin class dinamis
    ],

    safelist: [
        // Responsive visibility classes (PENTING untuk table/card toggle)
        "hidden",
        "block",
        "sm:hidden",
        "sm:block",
        "md:hidden",
        "md:block",
        "lg:hidden",
        "lg:block",
        "xl:hidden",
        "xl:block",
        "sm:!block",

        // Flexbox & Grid alignment (untuk card height consistency)
        "items-stretch",
        "h-full",
        "flex",
        "flex-col",
        "flex-grow",
        "flex-shrink-0",
        "mt-auto",
        "line-clamp-1",
        "line-clamp-2",
        "leading-snug",
        "leading-normal",
        "sm:leading-normal",

        // Slider dots
        "bg-[#B62127]",
        "bg-gray-400",

        // Tombol navigasi
        "p-1",
        "p-2",
        "sm:p-2",
        "w-2",
        "w-3",
        "h-2",
        "h-3",

        // Background opacity / hover
        "bg-black/30",
        "hover:bg-black/50",

        // Safelist pattern untuk semua Tailwind colors (agar sekali build langsung include semua)
        {
            pattern:
                /bg-(red|blue|green|yellow|purple|pink|indigo|teal|orange|cyan|lime|emerald|sky|violet|fuchsia|rose|amber|slate|gray|zinc|neutral|stone)-(50|100|200|300|400|500|600|700|800|900)/,
            variants: ["hover", "focus", "active"],
        },
        {
            pattern:
                /text-(red|blue|green|yellow|purple|pink|indigo|teal|orange|cyan|lime|emerald|sky|violet|fuchsia|rose|amber|slate|gray|zinc|neutral|stone)-(50|100|200|300|400|500|600|700|800|900)/,
            variants: ["hover", "focus", "active"],
        },
        {
            pattern:
                /border-(red|blue|green|yellow|purple|pink|indigo|teal|orange|cyan|lime|emerald|sky|violet|fuchsia|rose|amber|slate|gray|zinc|neutral|stone)-(50|100|200|300|400|500|600|700|800|900)/,
            variants: ["hover", "focus", "active"],
        },
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: "#b62127", // Bisa dipakai di slider misal bg-primary
            },
        },
    },

    plugins: [forms],
};
