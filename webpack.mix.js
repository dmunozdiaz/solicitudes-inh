const mix = require('laravel-mix');
const glob = require('glob');
const path = require('path');
const ReplaceInFileWebpackPlugin = require('replace-in-file-webpack-plugin');
const rimraf = require('rimraf');
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */


mix.browserSync('http://localhost:8077/');

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
    ]);

//Login
mix.js('resources/js/login/login.js', 'public/js/login');
mix.js('resources/js/login/reset-password.js', 'public/js/login'); 
mix.js('resources/js/login/forgot-password.js', 'public/js/login');



mix.css('resources/css/custom.css', 'public/css');

