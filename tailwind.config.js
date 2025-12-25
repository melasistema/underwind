import defaultTheme from 'tailwindcss/defaultTheme.js'
import typography from '@tailwindcss/typography'

export default {
    content: [
        './*.php',
        './inc/**/*.php',
        './template-parts/**/*.php',
        './src/js/**/*.js'
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    plugins: [
        typography,
    ],
}
