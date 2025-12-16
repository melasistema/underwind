import '../css/app.css'
import Alpine from 'alpinejs'

window.Alpine = Alpine

// Define global Alpine component
Alpine.data('menu', () => ({
    open: false,
    toggle() {
        this.open = !this.open
    },
}))

Alpine.start()

// Dev-only log
if (import.meta.env.DEV) {
    console.log('%cUnderwind Dev Mode ✅', 'color: #4ade80; font-weight: bold;')
}
