import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { viteStaticCopy } from 'vite-plugin-static-copy';

export default defineConfig({
    
    plugins: [
        laravel({
            input: [
                'resources/css/style.css',
                'resources/js/script.js',
                'resources/js/productos.js',
                'resources/js/puntos.js',
                'resources/js/productoPuntos.js',
                'resources/js/addproducts.js',
                'resources/js/metricas.js',
                'resources/js/cierrecaja.js',
            ],
            refresh: true,
        }),

        viteStaticCopy({
            targets: [
                { src: 'resources/css', dest: '' },
                { src: 'resources/fonts', dest: '' },
                { src: 'resources/img', dest: '' },
                { src: 'resources/js', dest: '' },
                { src: 'resources/plugins', dest: '' },
                { src: 'resources/scss', dest: '' },
            ],
        }),
    ],
});