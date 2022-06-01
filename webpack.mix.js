const mix = require('laravel-mix');

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

mix.js('resources/js/app.js', 'public/js').postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
        require('autoprefixer'),
    ])
    .js('ExternalAssets/app.js', 'public/js/dispense.js')
    .js('ExternalAssets/Nda.js', 'public/js/Nda.js')
    .js('ExternalAssets/MgtDrugs.js', 'public/js/MgtDrugs.js')
    .postCss('ExternalAssets/app.css', 'public/css/main.css');

mix.disableSuccessNotifications();
