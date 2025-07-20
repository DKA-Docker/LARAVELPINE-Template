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
import { resolve } from "path"
import * as zlib from "node:zlib";

export default defineConfig({
    build: {
        sourcemap : false,
    },
    plugins: [
        laravel({
            input: [
                /** base Assets**/
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/ts/main.tsx',
                /** Scope of pages **/
                'resources/js/maxton/pages/dashboard.js',
                'resources/js/maxton/pages/settings/managements/accounts.js'
            ],
            refresh: true,
        }),
        // @ts-ignore
        svgr(),
        react(),
        tailwindcss(),
        viteTsconfigPaths(),
        obfuscatorPlugin({
            /** Jalankan Obfucated Hanya Di Mode Build **/
            apply : "build",
            /** Opsi Tambahan**/
            options : {
                /** Matikan Debug dan Nyalakan Proteksi**/
                debugProtection : false,
                /** Jangan Gabung Import Karna Project Menggunakan Lazy load **/
                ignoreImports: true,
                /** Hapus Semua Console Output **/
                disableConsoleOutput: true,
            }
        }),
        ViteMinifyPlugin({
            /** Hapus whitespace Kosong **/
            removeTagWhitespace : true,
            preventAttributesEscaping : true,
            collapseInlineTagWhitespace : true,
            /** Hapus Tags Yang Tidak Dibutuhkan */
            removeOptionalTags : true,
            /** Balik Baris Baru **/
            preserveLineBreaks : true,
            /** Hapus Attributs Redundant **/
            removeRedundantAttributes : true
        }),
        viteCompression({
            algorithm: 'brotliCompress',
            ext: '.dka',
            compressionOptions: {
                params: {
                    [zlib.constants.BROTLI_PARAM_QUALITY]: 11 // 🔥 kompresi tingkat akhir
                }
            },
            threshold: 1024, // hanya compress file > 1KB
            deleteOriginFile: false, // true kalau mau hapus file asli
        }),
        inspect(),
        // @ts-ignore
        visualizer({
            title : ` apps ${name} - version ${version}`,
            filename: 'public/stats.html',
            gzipSize: true,
            brotliSize: true,
        })

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
        host : '0.0.0.0',
        port : 5173,
    }
});
