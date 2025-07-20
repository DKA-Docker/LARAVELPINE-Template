import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import react from '@vitejs/plugin-react';
import viteTsconfigPaths from 'vite-tsconfig-paths'
import viteCompression from 'vite-plugin-compression';
import { visualizer } from 'rollup-plugin-visualizer';
import inspect from 'vite-plugin-inspect';
import obfuscatorPlugin from "vite-plugin-javascript-obfuscator";
import { ViteMinifyPlugin } from 'vite-plugin-minify'
import svgr from '@svgr/rollup';
import { version, name } from "./package.json";
import { resolve } from "path";
import * as zlib from "node:zlib";
import * as fs from "node:fs";

export default defineConfig(({ mode }) => {
    const theme = process.env.VITE_THEME_NAME || 'maxton';
    // 2. Helper check file exist (optional)
    const safeInput = (file) => fs.existsSync(resolve(__dirname, file)) ? file : null;
    // 3. Input list dinamis (cek folder tema juga bisa)
    const input = [
        'resources/css/app.css',
        'resources/js/app.js',
        'resources/ts/main.tsx',
        safeInput(`resources/js/${theme}/pages/dashboard.js`),
        safeInput(`resources/js/${theme}/pages/settings/managements/accounts.js`)
    ].filter(Boolean); // Remove nulls

    return {
        build: {
            sourcemap: false,
        },
        plugins: [
            laravel({
                input,
                refresh: true,
            }),
            // Plugin bawaan kamu
            svgr(),
            react(),
            tailwindcss(),
            viteTsconfigPaths(),
            obfuscatorPlugin({
                apply: 'build',
                options: {
                    debugProtection: false,
                    ignoreImports: true,
                    disableConsoleOutput: true,
                },
            }),
            ViteMinifyPlugin({
                removeTagWhitespace: true,
                preventAttributesEscaping: true,
                collapseInlineTagWhitespace: true,
                removeOptionalTags: true,
                preserveLineBreaks: true,
                removeRedundantAttributes: true,
            }),
            viteCompression({
                algorithm: 'brotliCompress',
                ext: '.dka',
                compressionOptions: {
                    params: {
                        [zlib.constants.BROTLI_PARAM_QUALITY]: 11,
                    },
                },
                threshold: 1024,
                deleteOriginFile: false,
            }),
            inspect(),
            visualizer({
                title: `apps ${name} - version ${version}`,
                filename: 'public/stats.html',
                gzipSize: true,
                brotliSize: true,
            }),
        ],
        resolve: {
            alias: {
                '@resources': resolve(__dirname, 'resources/ts'),
                '@res': resolve(__dirname, 'resources/ts'),
                '@css': resolve(__dirname, 'resources/css'),
                '@js': resolve(__dirname, 'resources/js'),
            },
        },
        server: {
            host: '0.0.0.0',
            port: 5173,
        },
        define: {
            VITE_THEME_NAME: JSON.stringify(theme),
        },
    };
});
