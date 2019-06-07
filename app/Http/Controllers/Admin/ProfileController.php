<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// 以下を追記することでProfile Modelが扱えるようになる
use App\Profile;

class ProfileController extends Controller
{
    /*以下のadd, create, edit, update それぞれのActionを追加(課題)。
    public function add(),public function edit()のviewはroutes/web.phpとつながってる。*/
      public function add()
  {
      return view('admin.profile.create'); //PHP/Laravel 10の課題4.resources/views/admin/profileフォルダにcreate.blade.php作成？。
  }

  public function create(Request $request) //PHP/Laravel 16.課題1で追加、ここはNewsContoroller.phpを参考
  {
      $this->validate($request, Profile::$rules); //左オレンジのとこNewsControllerではNewsだった、ここはProfileにした
      $news = new Profile;
      $form = $request->all();

      // フォームから画像が送信されてきたら、保存して、$news->image_path に画像のパスを保存する
      if (isset($form['image'])) {
        $path = $request->file('image')->store('public/image');
        $news->image_path = basename($path);
      } else {
          $news->image_path = null;
      }

      // フォームから送信されてきた_tokenを削除する
      unset($form['_token']);
      // フォームから送信されてきたimageを削除する
      unset($form['image']);

      // データベースに保存する
      $news->fill($form);
      $news->save();
      // admin/profile/createにリダイレクトする
      return redirect('admin/profile/create');
  }

 public function edit(Request $request)
 {
     // News Model(Providers/Profile.phpモデル)からデータを取得する
      $news = Profile::find($request->id);
      if (empty($news)) {
        abort(404);    
      }
     
      return view('admin.profile.edit'); /*PHP/Laravel 10の課題4.resources/views/admin/profileフォルダに
      edit.blade.php作成？。ここはreturn view('admin.profile.edit'),['news_form' => $news]);にする確認？*/
 }
 public function update()
 {
     // Validationをかける
      $this->validate($request, Profile::$rules);
      // News Modelからデータを取得する
      $news = Profile::find($request->id);
      // 送信されてきたフォームデータを格納する
      $news_form = $request->all();
      //以下のif文書かないと実は画像を変更した時にエラーになってしまうという。
      if (isset($news_form['image'])) {
        $path = $request->file('image')->store('public/image');
        $news->image_path = basename($path);
        unset($news_form['image']);
      } elseif (isset($request->remove)) {
        $news->image_path = null;
        unset($news_form['remove']);
      }
      unset($news_form['_token']);

      /*該当するデータを上書きして保存する
      $news->fill($news_form)->save();は、$news->fill($news_form);と$news->save();を短縮したもの*/
      $news->fill($news_form)->save();
      
      return redirect('admin/profile/edit');
 }
}
