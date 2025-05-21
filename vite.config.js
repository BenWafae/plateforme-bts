import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    server: {
        host: 'localhost',
        port: 5173, // Le port Vite
        hmr: {
            host: 'localhost',
        },
        // Optionnel : si tu veux éviter les problèmes de CORS avec echo-server
        watch: {
            usePolling: true,
        }
    }
});