import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import commonjs from 'vite-plugin-commonjs';
import react from '@vitejs/plugin-react';
import * as path from 'path';

export default defineConfig({
    build: {
        sourcemap : false,
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/ts/main.tsx'
            ],
            refresh: true,
        }),
        react(),
        tailwindcss()
    ],
    resolve: {
        alias: {
            '@resources': path.resolve(__dirname, 'resources/ts'),
            '@res': path.resolve(__dirname, 'resources/ts'),
            '@css': path.resolve(__dirname, 'resources/css'),
            '@js': path.resolve(__dirname, 'resources/js'),
        },
    },
    server: {
        host : '0.0.0.0',
        port : 5173,
    }
});
