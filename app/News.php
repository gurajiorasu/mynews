<?php
/*Laravel でデータベースを扱うためには、Model という機能を使用します。まず、artisan を使用してModelの雛形を生成する。
ここはコマンド　$php artisan make:model News で作成。この News Modelを使用して、news テーブルにニュースのデータを格納します　*/
namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    /*以下をValidation追加した。PHP/Laravel 14。Modelでデータを保存する前に、フォームからデータを送信されてきた値が正しいかどうか
    確認が必要な場合があります。例えば、ニュースへ追加するときに、タイトルが入力されていなかった場合は不完全なデータを
    登録してしまいます。このようなデータの不備をあらかじめ防ぐために検証する仕組みがバリデーションです。
    Validationを設定するにはたくさんの方法がありますが、今回はModelに定義。バリデーションでデータが異常であることを見つけたとき
    には、データを保存せずに入力フォームへ戻すようにします。戻った先の画面では、データを登録できなかった理由を表示する。
    admin/news/create.blade.php を再度確認*/
    protected $guarded = array('id');
     public static $rules = array(
        'title' => 'required',
        'body' => 'required',
    );
    
    /* PHP/Laravel 17 編集履歴を実装しようで以下を追記。Newsモデルに関連付けを行う(app/History.php)。
    News モデルに関連付けを定義することで、News モデルから $news->histories() のような記述で簡単に
    アクセスすることができます。次にやるのはNewsController の update Action編集*/
    public function histories()
    {
      return $this->hasMany('App\History');

    }
    
}
