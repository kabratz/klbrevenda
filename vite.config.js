import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue'; // Importa o plugin Vue
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true,
    }),
    vue(), // Ativa o plugin Vue
  ],
});