import { defineConfig, loadEnv } from "vite"
import laravel from "laravel-vite-plugin"
import tailwindcss from "@tailwindcss/vite"
import viteTsconfigPaths from "vite-tsconfig-paths"
import viteCompression from "vite-plugin-compression"
import { ViteMinifyPlugin } from "vite-plugin-minify"
import obfuscatorPlugin from "vite-plugin-javascript-obfuscator"
import * as zlib from "node:zlib"
import * as fs from "node:fs"
import path from "node:path"

export default defineConfig((config) => {
    /*const env = loadEnv(config.mode, process.cwd(), '')*/
    const rootDir = process.cwd();
    const themesRoot = path.join(rootDir, 'resources/theme');
    const inputAssets = fs.readdirSync(themesRoot, { withFileTypes: true })
        .filter((d) => d.isDirectory())
        .flatMap((dir) => {
            const base = `resources/theme/${dir.name}`;
            // list kemungkinan entry per tema
            const candidates = [
                `${base}/css/app.css`,
                `${base}/js/app.ts`,
                `${base}/js/app.js`,
            ];
            return candidates.filter((relPath) =>
                fs.existsSync(path.join(rootDir, relPath)),
            );
        });

    return {
        plugins: [
            laravel({
                input: inputAssets,
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
