const plugin = require("tailwindcss/plugin");

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {},
    },
    plugins: [
        require("tailwindcss-primeui"),
        require("tailwind-scrollbar-hide"),
        require("tailwind-scrollbar"),
    ],
};
