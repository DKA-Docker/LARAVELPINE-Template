import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
import * as path from 'path';

export default defineConfig({
    build: {
        sourcemap : false
    },
    plugins: [
        laravel({
            input: ['resources/ts/app.tsx'],
            refresh: true,
        }),
        react()
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
