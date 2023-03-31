import { defineConfig } from 'vite';
import path from "path";

import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

import Icons from 'unplugin-icons/vite';
import AutoImport from 'unplugin-auto-import/vite';
import Components from 'unplugin-vue-components/vite';

import IconsResolver from 'unplugin-icons/resolver';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        Icons({}),
        AutoImport({
            imports: [
                'vue',
                {
                    '@inertiajs/vue3': [
                        'useForm', 'usePage', 'useRemember', 'router',
                    ],
                },
            ],
            dirs: ['resources/js/Composables'],
            dts: 'resources/js/auto-imports.d.ts',
        }),
        Components({
            resolvers: [IconsResolver()],
            dirs: ['resources/js/Components', 'resources/js/Layouts'],
            dts: 'resources/js/components.d.ts',
        }),
    ],
    resolve: {
        alias: {
            "@": path.resolve(__dirname, "./resources/js"),
        },
    },
    server: {
        hmr: {
            host: 'localhost',
        },
    },
});
