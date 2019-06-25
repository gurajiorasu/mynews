<?php
/*PHP/Laravel 17課題2.ここはコマンド$ php artisan make:model Profile_Historyで任意で付けた*/

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfileHistory extends Model
{
    //以下を追加
     public static $rules = array(
        'profile_id' => 'required',
        'edited_at' => 'required',
    );
    
    
}
