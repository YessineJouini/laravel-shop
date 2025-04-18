import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/sass/app.scss', // make sure this line exists
        'resources/js/app.js',
      ],
      refresh: true,
    }),
  ],
});
