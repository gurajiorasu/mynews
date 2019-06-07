<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
    
}
