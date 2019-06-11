<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// 以下を追記することでProfile Modelが扱えるようになる
use App\Profile;
//profiile_History.php モデルの使用を宣言するため、同様に追記して下さい。PHP/Laravel 17で追加。
use App\profile_History;
//PHP/Laravel 17で追加。タイムスタンプを使うCarbonはモデル、モデルを使う時は宣言が必要
use Carbon\Carbon;

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
      //profile.phpのクラス名のためにProfileのPが大文字
      $this->validate($request, Profile::$rules); //左オレンジのとこNewsControllerではNewsだった、ここはProfileにした
      $profile = new Profile;
      $form = $request->all();

      // フォームから画像が送信されてきたら、保存して、$news->image_path に画像のパスを保存する
      if (isset($form['image'])) {
        $path = $request->file('image')->store('public/image');
        $profile->image_path = basename($path);
      } else {
          $profile->image_path = null;
      }

      // フォームから送信されてきた_tokenを削除する
      unset($form['_token']);
      // フォームから送信されてきたimageを削除する
      unset($form['image']);

      // データベースに保存する
      $profile->fill($form);
      $profile->save();
      // admin/profile/createにリダイレクトする
      return redirect('admin/profile/create');
  }

 public function edit(Request $request)
 {
     // News Model(Providers/Profile.phpモデル)からデータを取得する。viewに渡してる
      $profile = Profile::find($request->id);
      if (empty($profile)) {
        abort(404);    
      }
     
      return view('admin.profile.edit',['profile_form' => $profile]); /*PHP/Laravel 10の課題4.resources/views/admin/profileフォルダに
      edit.blade.php作成？。ここはreturn view('admin.profile.edit'),['news_form' => $news]);にする確認？*/
 }
 public function update()
 {
     // Validationをかける
      $this->validate($request, Profile::$rules);
      // Profile Modelからデータを取得する
      $profile = Profile::find($request->id);
      // 送信されてきたフォームデータを格納する
      $profile_form = $request->all();
      //以下のif文書かないと実は画像を変更した時にエラーになってしまうという。
      if (isset($profile_form['image'])) {
        $path = $request->file('image')->store('public/image');
        $profile->image_path = basename($path);
        unset($profile_form['image']);
      } elseif (isset($request->remove)) {
        $profile->image_path = null;
        unset($profile_form['remove']);
      }
      unset($profile_form['_token']);

      /*該当するデータを上書きして保存する
      $news->fill($news_form)->save();は、$news->fill($news_form);と$news->save();を短縮したもの
      65行目と合わせるprofile_form（変数名）*/
      $profile->fill($profile_form)->save();
      
      //PHP/Laravel 17課題2で追加
      $history = new History;
        $history->profile_id = $profile->id;
        $history->edited_at = Carbon::now();
        $history->save();
      
      return redirect('admin/profile/edit');
 }
}
