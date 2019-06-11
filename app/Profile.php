<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

//クラス名Profileは、Admin/ProfileController.phpで使っている
class Profile extends Model
{
    /* ここはコマンド$php artisan make:model Profile で作成。以下を追記PHP/Laravel 14.課題5。
    Profile というModelを作成し、 名前(name)、性別(gender)、趣味(hobby)、自己紹介(introduction)に
    対してValidationをかけるようにした。ここはコマンド　$php artisan make:model Profile で作成。*/
    protected $guarded = array('id');
    
    public static $rules = array(
        'name' => 'required',
        'gender' => 'required',
        'hobby' => 'required',
        'introduction' => 'required',
    );
    /* PHP/Laravel 17 課題2で以下を追記。Newsモデルに関連付けを行う(app/History.php)。
    News モデルに関連付けを定義することで、News モデルから $news->histories() のような記述で簡単に
    アクセスすることができます。次にやるのはNewsController の update Action編集*/
    public function histories()
    {
      return $this->hasMany('App\Profile_History');

    }
    
}
