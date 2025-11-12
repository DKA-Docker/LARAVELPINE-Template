import {defineConfig, loadEnv} from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
export default defineConfig(({ mode }) => {
    const env = loadEnv(mode, process.cwd(), '')
    const theme = env.THEME_NAME || 'laravel'

    return {
        plugins: [
            laravel({
                input: [
                    `resources/theme/${theme}/css/app.css`,
                    `resources/theme/${theme}/js/app.js`,
                ],
                refresh: true,
            }),
            tailwindcss(),
        ],
    }
})

