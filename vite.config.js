import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { fileURLToPath, URL } from 'url';

export default defineConfig({
    server:{
        host:'0.0.0.0',
        proxy:{
            '/api/foo':'http://localhost:8081/api/normal'
        }
    },
    plugins: [
        vue(),
        laravel({
            //input: 'resources/js/app.ts',
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            vue: "vue/dist/vue.esm-bundler.js",
            '@': fileURLToPath(new URL('./resources/js/', import.meta.url)),
            '~': fileURLToPath(new URL('./public', import.meta.url)),
            '*': fileURLToPath(new URL('./node_modules', import.meta.url))
        },
    },
});
