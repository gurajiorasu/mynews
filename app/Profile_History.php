<?php
/*PHP/Laravel 17課題2.ここはコマンド$ php artisan make:model Profile_Historyで任意で付けた*/

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile_History extends Model
{
    //以下を追加
     public static $rules = array(
        'name' => 'required',
        'gender' => 'required',
        'hobby' => 'required',
        'introduction' => 'required',
    );
    
    // profileモデルに関連付けを行う
    public function histories()
    {
      return $this->hasMany('App\Profile_History');

    }
}
