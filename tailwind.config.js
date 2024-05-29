/** @type {import('tailwindcss').Config} */
export default {
    daisyui: {
        themes: [
            {
                light1: {
                    "primary": "#f18533",    // Яркий оранжевый для основного цвета
                    "secondary": "#4A4A4A",  // Темно-серый для вторичного цвета
                    "accent": "#A3E635",     // Светло-зеленый для акцентного цвета
                    "neutral": "#dadada",    // Светло-серый для нейтрального фона
                    "base-100": "#FFFFFF",   // Белый для основного фона
                    "info": "#17A2B8",       // Голубой для информационных сообщений
                    "success": "#28A745",    // Зеленый для сообщений об успехе
                    "warning": "#FFC107",    // Желтый для предупреждений
                    "error": "#DC3545",      // Красный для сообщений об ошибках
                },
                dark1: {
                    "primary": "#FF8A00", // Основной цвет — ярко-оранжевый
                    "secondary": "#1E1E2E", // Вторичный цвет — тёмно-синий
                    "accent": "#FF4500", // Акцентный цвет — оранжево-красный
                    "neutral": "#121212", // Нейтральный цвет — тёмный
                    "base-100": "#181818", // Основной фон — очень тёмный
                    "info": "#0D7377", // Информационный цвет — зелёный
                    "success": "#32CD32", // Успешный цвет — лаймовый
                    "warning": "#FFA500", // Предупреждающий цвет — оранжевый
                    "error": "#FF204E" // Ошибочный цвет — красный
                }
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
