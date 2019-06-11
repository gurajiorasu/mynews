<!--PHP/Laravel 17 編集履歴を実装しようで作成。コマンド$ php artisan make:migration create_histories_table でこのファイル作成
編集履歴は、特定のニュースをいつ変更したか、日付と時刻を記録し、参照することができる機能です。
編集画面でデータを更新するタイミングで histories というテーブルにデータを登録し、編集画面でその一覧を見られるように実装します。
ここでは編集履歴テーブルの作成と関連付けをする。
以下編集したらMigrationを実行しますコマンド$php artisan migrate 。
次にやるのはコマンド$php artisan make:model Historyで作成されたapp/Providers/History.php編集。
profile用のhistoriesを作る場合は別テーブルを新たに作成する。historyテーブルはあくまでnewsの変更履歴の
情報を扱うものなので、別の用途での使用はだめで、今回はprofile_historiesとして作成した。-->
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*以下編集したtable->bigIncrementsをincrementsにし、integer('news_id')とstring('edited_at')を追加した*/
        Schema::create('histories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('news_id');
            $table->string('edited_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('histories');
    }
}
