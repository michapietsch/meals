import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import basicSsl from '@vitejs/plugin-basic-ssl';

export default defineConfig({
    plugins: [
        basicSsl(),
        laravel({
            input: 'resources/js/app.js',
            ssr: 'resources/js/ssr.js',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],

    base: "/",

    preview: {
        port: 5173,
        strictPort: true,
        https: true,
    },

    server: {
        port: 5173,
        strictPort: true,
        https: true,
        host: true,
        origin: "https://0.0.0.0:5173",
    },
});
