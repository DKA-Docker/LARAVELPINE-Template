import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import viteTsconfigPaths from 'vite-tsconfig-paths';
import svgr from '@svgr/rollup'
import viteCompression from 'vite-plugin-compression';
import { ViteMinifyPlugin } from 'vite-plugin-minify'
import obfuscatorPlugin from "vite-plugin-javascript-obfuscator";
import * as zlib from "node:zlib";

export default defineConfig(({ mode }) => {
    const env = loadEnv(mode, process.cwd(), '')
    const theme = env.THEME_NAME || 'laravel'

    return {
        plugins: [
            laravel({
                input: [
                    `resources/theme/${theme}/css/app.css`,
                    `resources/theme/${theme}/js/app.ts`,
                ],
                refresh: true,
            }),
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
        ],
        build: {
            output: {
                manualChunks(id) {
                    if (id.includes('node_modules')) {
                        const chunks = [
                            ['vendor-mapbox', ['mapbox-gl', '@mapbox']],
                            ['vendor-apexcharts', ['apexcharts']],
                            ['vendor-jquery', ['jquery']],
                        ];

                        const found = chunks.find(([_, libs]) => libs.some(lib => id.includes(lib)));
                        if (found) return found[0];

                        return 'vendor';
                    }
                }
            },
        },
        server : {
            host: '0.0.0.0'
        }
    }
})
