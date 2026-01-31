import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true, // hot reload
        }),
    ],
    build: {
        minify: "terser",
        terserOptions: {
            compress: {
                drop_console: true, // Remove console.log in production
            },
        },
        rollupOptions: {
            output: {
                manualChunks: {
                    vendor: ["alpinejs"],
                },
            },
        },
        cssMinify: true,
        cssCodeSplit: true,
    },
});
