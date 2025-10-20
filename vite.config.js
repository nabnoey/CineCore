import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwind from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        // Enable Tailwind CSS v4 processing
        tailwind(),
        laravel({
            // Include Tailwind CSS entry so @vite('resources/css/app.css') resolves in build
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/css/app.css',
            ],
            refresh: true,
        }),
    ],
});