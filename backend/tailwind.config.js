import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            colors: {
                brand: {
                    darkest: '#16425B',
                    dark: '#2F6690',
                    DEFAULT: '#3A7CA5',
                    light: '#81C3D7',
                    lightest: '#E8F3F7',
                    muted: '#D9DCD6',
                },
            },

            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                display: ['"Playfair Display"', ...defaultTheme.fontFamily.serif],
                body: ['"DM Sans"', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};