import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
const colors = require('tailwindcss/colors');
const plugin = require('tailwindcss/plugin');
/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],

    theme: {
        extend: {
            colors: {
                light: {
                    background: '#ffffff',
                    text: '#1a202c',
                    border: '#e2e8f0',
                },
                dark: {
                    background: '#1a202c',
                    text: '#ffffff',
                    border: '#4a5568',
                },
                children: {
                    background: '#ffe4e1',
                    text: '#ff69b4',
                    border: '#ffb6c1',
                },
                youth: {
                    background: '#e0ffe4',
                    text: '#006400',
                    border: '#32cd32',
                },
                adults: {
                    background: '#fdf5e6',
                    text: '#8b4513',
                    border: '#deb887',
                },
            },
        },
    },
    plugins: [
        plugin(function ({ addBase, theme }) {
            addBase({
                body: {
                    backgroundColor: theme('colors.light.background'),
                    color: theme('colors.light.text'),
                },
                '.dark': {
                    backgroundColor: theme('colors.dark.background'),
                    color: theme('colors.dark.text'),
                },
                '.theme-children': {
                    backgroundColor: theme('colors.children.background'),
                    color: theme('colors.children.text'),
                },
                '.theme-youth': {
                    backgroundColor: theme('colors.youth.background'),
                    color: theme('colors.youth.text'),
                },
                '.theme-adults': {
                    backgroundColor: theme('colors.adults.background'),
                    color: theme('colors.adults.text'),
                },
            });
        }),

        forms],
};
