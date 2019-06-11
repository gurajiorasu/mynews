<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// 以下を追記することでNews Model(News.php)クラスが扱えるようになる
use App\News;
//History.php モデルの使用を宣言するため、同様に追記して下さい。PHP/Laravel 17で追加。
use App\History;
//PHP/Laravel 17で追加。タイムスタンプを使うCarbonはモデル、モデルを使う時は宣言が必要
use Carbon\Carbon;
//PHP/Laravelコース - Herokuへの画像のアップロードで追加。imageの保存をAWSのS3になるよう変更していきましょう。
use Storage;

class NewsController extends Controller
{
    /*以下を追記しAction追加。ActionとはLaravel特有の言葉で、Controllerが持つ機能のことを指します。
    具体的には、Controller内に実装した関数(厳密にはメソッドといいます) のことを指します*/
     public function add()
  {
      return view('admin.news.create');
      /*NewsControllerに、addというActionを実装することができました。しかし残念ながらまだこのActionは使用されません。
      理由としては、Routingの設定をしないとこのActionを使われることが無いからです。
      その後。Routing(web.phpに)設定後、view(‘admin.news.create’);これは、admin/newsディレクトリ配下のcreate.blade.html 
      というファイルを呼び出すという意味です。つまり、resources/views/admin/newsディレクトリ配下に
      create.blade.htmlファイルを作成する必要があるということになります*/
  }
  
      // 以下PHP/Laravel 13 ニュース投稿画面を作成しようで追記
      public function create(Request $request)
      {
          
      // 以下を追記、save();までPHP/Laravel 14で追加
      // Varidationを行う
      $this->validate($request, News::$rules);

      $news = new News;
      $form = $request->all();

      // フォームから画像が送信されてきたら、保存して、$news->image_path に画像のパスを保存する
      if (isset($form['image'])) {
        /*$path = $request->file('image')->store('public/image');
        $news->image_path = basename($path);　この2行分を消して以下の2行のように画像の保存先をS3に変更するため
        編集。*/
        $path = Storage::disk('s3')->putFile('/',$form['image'],'public');
        $news->image_path = Storage::disk('s3')->url($path);
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
          
          // admin/news/createにリダイレクトする
          return redirect('admin/news/create');
  }
      
        // PHP/Laravel 15 投稿したニュースの一覧を表示するために、NewsController.phpにindexアクションを以下を追記
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
          $posts = News::where('title', $cond_title)->get();
      } else {
          // それ以外はすべてのニュースを取得する
          $posts = News::all();
      }
      /*return view～がRequestにcond_titleを送っている,上に説明あり。
      index.blade.phpのファイルに取得したレコード（$posts）と、ユーザーが入力した文字列（$cond_title）を渡し、
      ページを開きます。ControllerではModelに対して where メソッドを指定して検索しています。
      where への引数で検索条件を設定します。ただし、検索条件となる名前が入力されていない場合は、
      登録してあるすべてのデータを取得します。*/
      return view('admin.news.index', ['posts' => $posts, 'cond_title' => $cond_title]);
      
  }
  
  /*PHP/Laravel 16 投稿したニュースを更新/削除しようでdit Action と update Actionを追記を追記。
  edit Actionは編集画面、update Actionは編集画面から送信されたフォームデータを処理する部分です*/
  public function edit(Request $request)
  {
      // News Model(Providers/News.phpモデル)からデータを取得する
      $news = News::find($request->id);
      if (empty($news)) {
        abort(404);    
      }
      return view('admin.news.edit', ['news_form' => $news]);
  }


  public function update(Request $request)
  {
      // Validationをかける
      $this->validate($request, News::$rules);
      // News Modelからデータを取得する
      $news = News::find($request->id);
      // 送信されてきたフォームデータを格納する
      $news_form = $request->all();
      //以下のif文書かないと実は画像を変更した時にエラーになってしまうという。
      if (isset($news_form['image'])) {
        /*$path = $request->file('image')->store('public/image');
        $news->image_path = basename($path);　この2行分を消して以下の2行のように画像の保存先をS3に変更するため
        編集。*/
        $path = Storage::disk('s3')->putFile('/',$form['image'],'public');
        $news->image_path = Storage::disk('s3')->url($path);
        unset($news_form['image']);
      } elseif (isset($request->remove)) {
        $news->image_path = null;
        unset($news_form['remove']);
      }
      unset($news_form['_token']);

      /*該当するデータを上書きして保存する
      $news->fill($news_form)->save();は、$news->fill($news_form);と$news->save();を短縮したもの*/
      $news->fill($news_form)->save();
      
      /*PHP/Laravel 17 編集履歴を実装しようで追記。NewsController の update Actionで、News Modelを保存するタイミングで、
      同時に History Modelにも編集履歴を追加するよう実装します。update Actionを次のように変更して下さい。
      この実装では、時刻を扱うために Carbon という日付操作ライブラリを使います。
      Carbon を使って取得した現在時刻を、History モデルの edited_at として記録します。
      次にやるのはnews/edit.blade.php編集*/
      $history = new History;
        $history->news_id = $news->id;
        $history->edited_at = Carbon::now();
        $history->save();

      return redirect('admin/news');
  }
  
  /*PHP/Laravel 16 データ削除 delete Actionを追加。一般的に削除に対応するアクション名はdeleteになります。
  データをセーブするときは、$news->save();でsaveメソッドを利用しましたが、データの場合はdelete()メソッドを使います。*/
   public function delete(Request $request)
  {
      // 該当するNews Modelを取得
      $news = News::find($request->id);
      // 削除する
      $news->delete();
      return redirect('admin/news/');
  }  
    
    
}
