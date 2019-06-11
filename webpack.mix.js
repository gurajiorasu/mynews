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
    .sass('resources/sass/admin.scss', 'public/css')追加したコンパイルしている。
    書いたらコマンドで$npm run watch を打ちコンパイルする。
    PHP/Laravel 11.課題6でprofile.scss追加*/
mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/admin.scss', 'public/css')
    .sass('resources/sass/profile.scss', 'public/css')
    .sass('resources/sass/front.scss', 'public/css'); /* PHP/Laravel 18でfront.scssをコンパイルするように追記
    記載したらコマンドで$npm run watch を打ちコンパイルする*/
