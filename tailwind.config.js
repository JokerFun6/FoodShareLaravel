/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    daisyui: {
        themes: [
            {
                light: {
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
                dark : {
                    "primary": "#FF8A00", // Основной цвет — ярко-оранжевый
                    "secondary": "#b0b0b0", // Вторичный цвет — тёмно-синий
                    "accent": "#A3E635", // Акцентный цвет — оранжево-красный
                    "neutral": "#121212", // Нейтральный цвет — тёмный
                    "base-100": "#383838", // Основной фон — очень тёмный
                    "info": "#17A2B8", // Информационный цвет — зелёный
                    "success": "#28A745", // Успешный цвет — лаймовый
                    "warning": "#FFC107", // Предупреждающий цвет — оранжевый
                    "error": "#DC3545" // Ошибочный цвет — красный
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
    plugins: [
        require("daisyui"),
        require('tailwind-scrollbar')({ nocompatible: true }),
    ]
}
