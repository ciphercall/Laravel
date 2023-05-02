const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

// mix.js('resources/js/app.js', 'public/js')
//     .sass('resources/sass/app.scss', 'public/css');

// seller
mix.js('resources/views/seller/items/vue/create.js', 'public/js/seller/items/create.js');
mix.js('resources/views/seller/items/vue/edit.js', 'public/js/seller/items/edit.js');
