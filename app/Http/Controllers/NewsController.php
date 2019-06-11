<?php
/*PHP/Laravel 18 一般ユーザーが読むニュースサイトを作成しようで作成した。
これまで投稿者（admin）としてのコードを書いて行きました。ここでは、閲覧者用のコードを書いて行きましょう。
投稿者が投稿した記事の一覧ページを作成しています。まず、コントローラを実装します。artisan でひな型を生成する
コマンド$ php artisan make:controller NewsController でapp/Http/Controllers/Auth/NewsController.phpができる。
管理画面で使用した Admin/NewsController.php と全く同じファイル名ですが、ディレクトリ階層が異なる点に注意。
次はfront.blade.php を作成する*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//追記
use Illuminate\Support\Facades\HTML;

//追記
use App\News;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $cond_title = $request->cond_title;
        // $cond_title が空白でない場合は、記事を検索して取得する
        if ($cond_title != '') {
            $posts = News::where('title', $cond_title).orderBy('updated_at', 'desc')->get();
        } else {
            /*News::all()はEloquentを使った、全てのnewsテーブルを取得するというメソッドです。
            次のsortByDesc()というメソッドは？これは、カッコの中の値（キー）でソートするためのメソッドになります。
            ちなみに、ソートとは並び替えることを意味します。ソートするためのメソッドは、次のような意味になります。
            sortBy(‘xxx’)：xxxで昇順に並べ換える。sortByDesc(‘xxx’)：xxxで降順に並べ換える。
            つまり、News::all()->sortByDesc('updated_at')は、「投稿日時順に新しい方から並べる」
            という並べ換えをしていることを意味しています。*/
            $posts = News::all()->sortByDesc('updated_at');
        }

        if (count($posts) > 0) {
            $headline = $posts->shift();
        } else {
            $headline = null;
        }

        // news/index.blade.php ファイルを渡している
        // また View テンプレートに headline、 posts、 cond_title という変数を渡している
        /*$headline = $posts->shift();は何をしているのか考えてみましょう。shift()メソッドは、配列の最初のデータを
        削除し、その値を返すメソッドです。配列を左にシフトする動作をするので、shiftメソッドと呼ばれます。
        例）
        $collection = array(“a”,”b”,”c”,”d”);
        $collection>shift();
        →”a”
        $collection->all();
        →array(“b”,”c”,”d”)
        つまり、$headline = $posts->shift();では、一番最新の記事を変数$headlineに代入し、$postsは代入された最新の
        記事以外の記事が格納されていることになります。なんでわざわざこんなことをしているのかというと、
        最新の記事とそれ以外の記事とで表記を変えたいために行なっています。*/
        return view('news.index', ['headline' => $headline, 'posts' => $posts, 'cond_title' => $cond_title]);
    }
}
