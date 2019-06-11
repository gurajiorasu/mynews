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
アクセスが来たら、Controller Admin\NewsController のAction addに渡す いう設定をしています。
PHP/Laravel 13 ニュース投稿画面を作成でRoute::group(['prefix' => 'admin'], function()から
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function()に変更した*/

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {
    Route::get('news/create', 'Admin\NewsController@add')->middleware('auth');
    Route::post('news/create', 'Admin\NewsController@create')->middleware('auth');/*admin/news/createにアクセスしたときに、getとpostの両方が
    設定されています。getの場合は add Actionを、 postの場合は create Action を呼び出すようにしています。
    これは通常のページの表示にはgetを受け取り、フォームを送信したときに受け取る場合にはpostを受け取るように指定しています。
    (Admin/ProfileControlleにadd & create Actionある)
    methodは通信形式基本はgetはユーザー見える、posはユーザーに見えないように渡す*/
    Route::get('news', 'Admin\NewsController@index')->middleware('auth'); //PHP/Laravel 15で追加
    Route::get('news/edit', 'Admin\NewsController@edit')->middleware('auth'); //PHP/Laravel 16 追記
    Route::post('news/edit', 'Admin\NewsController@update')->middleware('auth'); //PHP/Laravel 16 追記
    Route::get('news/delete', 'Admin\NewsController@delete')->middleware('auth'); //PHP/Laravel 16 追記
    Route::get('profile/create', 'Admin\ProfileController@add')->middleware('auth');
    /* admin/profile/createにアクセスしたらControllersのProfileControllerのadd Actionに。
    ここのmiddleware(下に説明書いてる)はPHP/Laravel 12の課題.2で追加した。*/
    Route::post('profile/create', 'Admin\ProfileController@create')->middleware('auth'); /*PHP/Laravel 13.課題3 admin/profile/create に 
    postメソッドでアクセスしたら ProfileController の create Action に割り当てる*/
    Route::get('profile/edit', 'Admin\ProfileController@edit')->middleware('auth'); /*admin/profile/editにアクセスしたら
    ControllersのProfileControllerのedit Actionに割り当てる。上同様同じくここのmiddleware(下に説明書いてる)はPHP/Laravel 12の課題.3で追加した*/
    Route::post('profile/edit', 'Admin\ProfileController@update')->middleware('auth'); /*PHP/Laravel 13.課題6 admin/profile/edit
    に postメソッドでアクセスしたら ProfileController の update Action に割り当てるように設定*/
    Route::get('news/create', 'Admin\NewsController@add')->middleware('auth');/*ログインしていない状態で管理画面にアクセスしようとしたときに、
    ログイン画面にリダイレクトするようにRoutingで設定。設定の最後に 「->middleware(‘auth’)」 と入れることで、リダイレクトされるようになります。
    PHP/Laravel 12の講義*/
    Route::get('/', 'NewsController@index')->middleware('auth'); //PHP/Laravel 18
    
    
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
