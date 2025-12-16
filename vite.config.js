import { defineConfig } from 'vite'
import path from 'path'

export default defineConfig(({ command }) => {
    const isDev = command === 'serve'

    return {
        base: isDev ? '/' : '/wp-content/themes/underwind/dist/',
        build: {
            outDir: 'dist',
            emptyOutDir: true,
            manifest: true,
            rollupOptions: {
                input: {
                    app: path.resolve(__dirname, 'src/js/app.js'),
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
