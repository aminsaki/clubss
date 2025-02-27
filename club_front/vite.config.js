import { fileURLToPath, URL } from 'node:url'
import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import vueJsx from '@vitejs/plugin-vue-jsx'
import UnpluginVueMacros from 'unplugin-vue-macros/vite';

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [
    vue(),
    vueJsx(),
    UnpluginVueMacros(),
  ],
  server: {
    port: 3000,
  },
  resolve: {
    mainFields: [
      'browser',
      'module',
      'main',
      'jsnext:main',
      'jsnext'
    ],
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url))
    }
  }
})
