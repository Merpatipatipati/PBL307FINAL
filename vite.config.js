import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js', 'resources/css/app.css'],
            refresh: true,
        }),
    ],
    optimizeDeps: {
        include: ['laravel-echo', 'socket.io-client'], // Tambahkan paket yang bermasalah di sini
    },
    build: {
        rollupOptions: {
            external: [] , // Jika diperlukan
        },
    },
    server: {
        host: '0.0.0.0',
        port: 5173,
        hmr: {
            host: '192.168.136.10',
        },
    },
});

