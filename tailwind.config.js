/** @type {import('tailwindcss').Config} */
export default {
    daisyui: {
        themes: [
            {
                mytheme: {
                    "primary": "#6d28d9",
                    "secondary": "#00d556",
                    "accent": "#5300ff",
                    "neutral": "#2a293a",
                    "base-100": "#122636",
                    "info": "#00cade",
                    "success": "#00b943",
                    "warning": "#f06c00",
                    "error": "#e6364a",
                },
            },
        ],
    },
    content: [
        // You will probably also need these lines
        "./resources/**/**/*.blade.php",
        "./resources/**/**/*.js",
        "./app/View/Components/**/**/*.php",
        "./app/Livewire/**/**/*.php",

        // Add mary
        "./vendor/robsontenorio/mary/src/View/Components/**/*.php"
    ],
    theme: {
        screens: {
            sm: '640px',
            md: '768px',
            lg: '1024px',
            xl: '1280px',
        },
        extend: {},
    },

    // Add daisyUI
    plugins: [require("daisyui")]
}
