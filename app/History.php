<?php
/*Modelの雛形を作成コマンド$php artisan make:model History でここのファイル出来る。PHP/Laravel 17 編集履歴を実装しよう*/
namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    /*以下を追加する。Validation追加、例えば、ニュースへ追加するときに、タイトルが入力されていなかった場合は不完全なデータを
    登録してしまいます。このようなデータの不備をあらかじめ防ぐために検証する仕組みがバリデーションです。
    News Modelとの関連を定義するために、app/News.php も追記する。
    次にやるのはapp/News.phpの追記*/
    protected $guarded = array('id'); //arrayは配列になる

    public static $rules = array(
        'news_id' => 'required',
        'edited_at' => 'required',
    );
}
