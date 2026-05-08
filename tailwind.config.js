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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    DEFAULT: '#E67726',
                    50: '#FDF1E9',
                    100: '#FBE3D3',
                    200: '#F8C7A7',
                    300: '#F4AB7B',
                    400: '#F18F4F',
                    500: '#E67726',
                    600: '#B85F1E',
                    700: '#8A4717',
                    800: '#5C300F',
                    900: '#2E1808',
                },
            },
        },
    },

    plugins: [forms],
};
