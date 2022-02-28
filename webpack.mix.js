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

mix.js('resources/js/app.js', 'public/assets/js')
    .js('resources/js/demo.js', 'public/assets/js')
    .postCss('resources/css/app.css', 'public/assets/css', [
        //
    ])
    .copy('resources/js/*.min.js', 'public/assets/js')
    .copyDirectory('resources/js/pages', 'public/assets/js/pages')
    .copy('resources/css/*.min.css', 'public/assets/css')
    .copy('resources/css/alt/adminlte.*.min.css', 'public/assets/css/alt');
