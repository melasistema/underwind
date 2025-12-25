import { defineConfig } from 'vite'
import path from 'path'

export default defineConfig(({ command }) => {
    const isDev = command === 'serve'

    return {
        base: isDev ? '/' : '',
        build: {
            outDir: 'dist',
            emptyOutDir: true,
            manifest: true,
            rollupOptions: {
                input: {
                    app: path.resolve(__dirname, 'src/js/app.js'),
                    'src/css/editor.css': path.resolve(__dirname, 'src/css/editor.css'),
                    'src/css/app.css': path.resolve(__dirname, 'src/css/app.css'),
                },
                output: {
                    assetFileNames: 'assets/[name]-[hash][extname]',
                    entryFileNames: 'assets/[name]-[hash].js',
                },
            },
        },
        server: {
            strictPort: true,
            port: 5173,
            cors: true, // allow WordPress to access dev assets
        },
    }
})
