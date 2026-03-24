import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue(),
        tailwindcss(),
    ],
    build: {
        chunkSizeWarningLimit: 500,
        rollupOptions: {
            output: {
                manualChunks(id) {
                    if (id.includes('node_modules')) {
                        if (id.includes('@inertiajs')) {
                            return 'vendor-inertia';
                        }
                        if (id.includes('/node_modules/axios/')) {
                            return 'vendor-axios';
                        }
                        if (id.includes('/node_modules/moment/')) {
                            return 'vendor-moment';
                        }
                        if (id.includes('/node_modules/ziggy-js/')) {
                            return 'vendor-ziggy';
                        }
                        if (id.includes('@phosphor-icons')) {
                            return 'vendor-icons';
                        }
                        if (id.includes('gsap')) {
                            return 'vendor-gsap';
                        }
                        if (id.includes('vuedraggable') || id.includes('sortablejs')) {
                            return 'vendor-drag';
                        }
                        return 'vendor-misc';
                    }
                }
            }
        }
    },
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
