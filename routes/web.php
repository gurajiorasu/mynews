<?php

/* Laravel ではそれぞれのアドレスには個別のコントローラとアクションを割り当てるように実装します、
http://XXXXXX.jp/login などや http://XXXXXX.jp/about　など 。
アクセスしたアドレスに応じて対応するControllerのActionを呼び出す仕組みのことをRoutingといいます。*/



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/* 以下はRoutingでURLとControllerのActionとを紐付ける。Routingを定義するこの書き方はRoutingの設定の中では少し複雑な書き方です！
Route::group　は、いくつかのRoutingの設定をgroup化する役割があります。
なぜgroup化したかというと、次に書かれている[‘prefix’ => ‘admin’] の設定を、その次の無名関数function(){}の中の全ての
Routingの設定に適用させたいからです。つまり今の段階では、 Route::get(‘news/create’, ‘Admin\NewsController@add’);の
Routingの設定に[‘prefix’ => ‘admin’]を適用させている、という設定をしています。
では、[‘prefix’ => ‘admin’] は何をしているのかと言うと、無名関数function(){} の中の設定のURLを http://XXXXXX.jp/admin/ 
から始まるURLにしています。例えば、 [‘prefix’ => ‘user’]　にすれば、http://XXXXXX.jp/user/ からはじまるURLを指定することにな
ります。Route::get(‘news/create’, ‘Admin\NewsController@add’); が肝心要の設定で、http://XXXXXX.jp/admin/news/create に
アクセスが来たら、Controller Admin\NewsController のAction addに渡す いう設定をしています。*/

Route::group(['prefix' => 'admin'], function() {
    Route::get('news/create', 'Admin\NewsController@add');
    Route::get('profile/create', 'Admin\ProfileController@add'); //admin/profile/createにアクセスしたらProfileControllerのadd Actionに。
    Route::get('profile/edit', 'Admin\ProfileController@edit'); //admin/profile/editにアクセスしたらProfileControllerのedit Actionに割り当てる。
    Route::get('news/create', 'Admin\NewsController@add')->middleware('auth');/*ログインしていない状態で管理画面にアクセスしようとしたときに、
    ログイン画面にリダイレクトするようにRoutingで設定。設定の最後に 「->middleware(‘auth’)」 と入れることで、リダイレクトされるようになります。
    PHP/Laravel 12*/
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
