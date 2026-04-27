/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['DM Sans', 'sans-serif'],
                display: ['Playfair Display', 'serif'],
            },
            colors: {
                brown: {
                    50:  '#fdf8f4',
                    100: '#f5ede6',
                    200: '#ede7df',
                    600: '#7c3a1e',
                    700: '#5c2910',
                    900: '#2d1a0e',
                },
                cream: '#f5f0eb',
            },
        },
    },
    plugins: [],
};
