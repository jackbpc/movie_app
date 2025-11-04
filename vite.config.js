import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',      // main app styles
                'resources/css/navbar.css',   // add your navbar CSS
                'resources/js/app.js'         // main JS
            ],
            refresh: true,
        }),
    ],
});
