import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Instrument Sans', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                splitify: {
                    teal: '#00B2A9',
                    navy: '#1A2B63',
                    coral: '#FF5757',
                    'light-gray': '#f5f5f7',
                    'dark-gray': '#2c2c2e',
                },
            },
            backgroundImage: {
                'gradient-primary': 'linear-gradient(135deg, #00B2A9, #1A2B63)',
            },
        },
    },

    plugins: [forms],
};
