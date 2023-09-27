/** @type {import('tailwindcss').Config} */
const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
  content: [
    "./resources/js/**/*.blade.php",
    "./resources/js/**/*.js",
    "./resources/js/**/*.vue",
    "../../vendor/laravel/nova/resources/js/**/*.vue",
  ],
  darkMode: 'class', // or 'media' or 'class'
  // safelist: [
  // {
  // pattern: /^grid-cols-(?:\d)+/,
  // pattern: /grid-cols-(?:\d)+/,
  // pattern: /^(?:\w+:)?grid-cols-(?:\d)+/,
  // variants: ['sm', 'md', 'lg'],
  // },
  // ],

  theme: {
    extend: {
      fontFamily: { sans: ['Nunito Sans', ...defaultTheme.fontFamily.sans] },
    },
  },
  plugins: [],
}
