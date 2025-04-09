import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'sans-serif'],
            },
            colors: {
                splitify: {
                    teal: '#00B2A9',
                    navy: '#1A2B63',
                    coral: '#FF5757',
                    'light-gray': '#f5f5f7',
                    'dark-gray': '#2c2c2e',
                },
                'splitify-teal': '#4EB8B9',
                'splitify-navy': '#18414E',
                'splitify-light-teal': '#E6F3F3',
                'splitify-gray': '#F8FAFB',
                'splitify-dark-gray': '#4A5568',
            },
            backgroundImage: {
                'gradient-primary': 'linear-gradient(135deg, #00B2A9, #1A2B63)',
            },
        },
    },

    plugins: [
        forms,
        function({ addUtilities }) {
            const newUtilities = {
                '[x-cloak]': {
                    display: 'none !important'
                }
            }
            addUtilities(newUtilities)
        }
    ],

    safelist: [
        'bg-red-100',
        'text-red-600',
        'bg-yellow-100',
        'text-yellow-600',
        'bg-green-100',
        'text-green-600',
    ],

    corePlugins: {
        preflight: true,
    },
};
