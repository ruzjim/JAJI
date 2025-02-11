import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { viteStaticCopy } from 'vite-plugin-static-copy';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/style.css', 'resources/js/script.js'],
            refresh: true,
        }),
        viteStaticCopy({
            targets: [
                { src: 'resources/css', dest: '' },
                { src: 'resources/fonts', dest: '' },
                { src: 'resources/img', dest: '' },
                { src: 'resources/js', dest: '' },
                { src: 'resources/json', dest: '' },
                { src: 'resources/plugins', dest: '' },
                { src: 'resources/scss', dest: '' },
            ]
        }),
    ],
    build: {
        manifest: true,
        outDir: 'public/build',
    },
});
