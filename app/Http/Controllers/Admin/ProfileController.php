<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// 以下を追記することでProfile Modelが扱えるようになる
use App\Profile;
//profiile_History.php モデルの使用を宣言するため、同様に追記して下さい。PHP/Laravel 17で追加。
use App\ProfileHistory;
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

 /* PHP/Laravel 15 投稿したニュースの一覧を表示するために、NewsController.phpにindexアクションを以下を追記。
      名前の付けかたについて、indexには、「索引」の意味があり、ニュース一覧画面は、ニュースの索引画面の意味合いがあるためここで
      indexにしてる。任意でつけているものですが、ある程度決めた方が、読みやすいプログラムになるのでよいです。
      （特にLaravelなどのフレームワークでは、命名ルールによってプログラマが書くコードの量を減らしている側面があるので命名は
      なるべくチュートリアルに出てくるような一般的なものが望ましいです）*/
      public function index(Request $request)
      {
      /*$requestの中のcond_titleの値を$cond_titleに代入しています。もし、$requestにcond_titleがなければnullが代入
      されます。では、このcond_titleはいったいどこから現れたのでしょうか？
      それは、最後のreturn view('admin.news.index', ['posts' => $posts, 'cond_title' => $cond_title]);が
      Requestにcond_titleを送っているのです。最初に開いた段階では、cond_titleは存在しないのです。
      これは投稿したニュースを検索するための機能として活用します。*/
      $cond_title = $request->cond_title;
      /*if文の動作、$cond_titleがnullの場合（elseについて）を見ていきましょう。$posts = News::all();をしています。
      これは、Newsモデルを使って、データベースに保存されている、newsテーブルのレコードを全て取得し、
      変数$postsに代入しているという意味です。$cond_titleにデータが存在する場合を考えましょう。
      $posts = News::where('title', $cond_title)->get();でwhereメソッドを使うと、newsテーブルの中のtitleカラムで
      $cond_title（ユーザーが入力した文字）に一致するレコードを全て取得することができます。取得したテーブルを
      $posts変数に代入しています。つまり、$cond_titleがあればそれに一致するレコードを、なければ全てのレコードを
      取得することになります。*/
      if ($cond_title != '') {
          // 検索されたら検索結果を取得する
          $posts = Profile::where('title', $cond_title)->get();
      } else {
          // それ以外はすべてのニュースを取得する
          $posts = Profile::all();
      }
      /*return view～がRequestにcond_titleを送っている,上に説明あり。
      index.blade.phpのファイルに取得したレコード（$posts）と、ユーザーが入力した文字列（$cond_title）を渡し、
      ページを開きます。ControllerではModelに対して where メソッドを指定して検索しています。
      where への引数で検索条件を設定します。ただし、検索条件となる名前が入力されていない場合は、
      登録してあるすべてのデータを取得します。
      ['posts' => $posts, 'cond_title' => $cond_title]は連想配列だと思う。
      例)$animals = ["cat" => "猫","dog" => "犬",];"cat" というキーで "猫"という値を保持しますよ、という key と value(animals) 
      をつなぐもの。PHPの連想配列では、「=>」という記号を使う、というものですね*/
      return view('admin.profile.index', ['posts' => $posts, 'cond_title' => $cond_title]);
      
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
 public function update(Request $request)
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
      $history = new ProfileHistory;
        $history->profile_id = $profile->id;
        $history->edited_at = Carbon::now();
        $history->save();
      
      return redirect('admin/profile/edit?id=' . $request->id);
 }
 /*PHP/Laravel 16 データ削除 delete Actionを追加。一般的に削除に対応するアクション名はdeleteになります。
      データをセーブするときは、$news->save();でsaveメソッドを利用しましたが、データの場合はdelete()メソッドを使います。*/
       public function delete(Request $request)
      {
          // 該当するNews Modelを取得
          $news = Profile::find($request->id);
          // 削除する
          $news->delete();
          return redirect('admin/profile/');
      }  
 
}
