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
/*最初のからここ書かれていて。mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');のみだったが、
    .sass('resources/sass/admin.scss', 'public/css')追加したコンパイルしている*/
mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/admin.scss', 'public/css');
