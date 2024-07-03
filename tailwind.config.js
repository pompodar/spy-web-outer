import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.jsx',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                darkpurple: '#443a55',
                brightpurple: '#883351',
                brightyellow: '#fcd51d !important',
                brightgreen: '#a7e9e6',
                background: 'linear-gradient(90deg, rgba(68,58,85,1) 0%, rgba(136,51,81,1) 100%)',
            },
            backgroundColor: {
                'gradient-custom': 'linear-gradient(90deg, rgba(68, 58, 85, 1) 0%, rgba(136, 51, 81, 1) 100%)',
            },
            width: {
            },
        },
    },

    plugins: [forms],
};
