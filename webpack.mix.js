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
/*最初からここ書かれていて。mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');のみだったが、
    .sass('resources/sass/admin.scss', 'public/css')追加した,コンパイルするように、Laravel Mixに教えます。
    書いたらコマンドで$ npm run watch を打ちコンパイルする。ここ追記したら$npm run watchするみたい！*/
mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/admin.scss', 'public/css')//admin.scssをコンパイルするように、Laravel Mixに教えます
    .sass('resources/sass/profile.scss', 'public/css')//PHP/Laravel 11.課題6でprofile.scss追加
    .sass('resources/sass/front.scss', 'public/css'); /* PHP/Laravel 18でfront.scssをコンパイルするように追記
    記載したらコマンドで$npm run watch を打ちコンパイルする*/
