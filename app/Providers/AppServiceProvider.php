<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
        /* PHP/Laravelコース - Herokuへのデプロイ。Procfileはheroku上にデプロイされたときに実行するコマンドを指定するもので、これがないとデプロイ後にエラーが
        発生してしまいます。このままではHTTP通信プロトコルがHTTPになってしまいます。現在ではHTTPSが標準になっているため、
        HTTPSに設定します。HTTPサーバーのApacheを利用するためにProcfileを作成する必要があります。
        。プロジェクト直下(mynews)にProcfileを作成しましょう以下を追記。
        プロジェクト直下(mynews)にProcfileを作成しましょう。
        コマンド$ echo "web: vendor/bin/heroku-php-apache2 public" > Procfile で作成*/
        if (\App::environment('production')) {
            \URL::forceScheme('https');
        }
    }
}
