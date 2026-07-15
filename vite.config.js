import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js'],
            refresh: ['resources/views/**'],
        }),
        vue(),
        tailwindcss(),
    ],
    resolve: {
        alias: {
            '@': '/resources/js',
        },
    },
    server: {
        host: '127.0.0.1',
        hmr: false,
        watch: {
            ignored: ['**/storage/**', '**/node_modules/**', '**/.git/**', '**/public/**'],
            usePolling: false,
        },
    },
});
