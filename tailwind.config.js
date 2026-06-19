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
                finance: {
                    navy: '#0f172a',
                    gold: '#d97706',
                    emerald: '#059669',
                    crimson: '#dc2626',
                    light: '#f8fafc',
                    card: '#ffffff',
                    muted: '#64748b',
                },
            },
        },
    },

    plugins: [forms],
};
