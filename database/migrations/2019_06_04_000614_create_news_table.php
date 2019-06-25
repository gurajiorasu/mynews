<?php
/*Migration・データベースでは、テーブルという単位で分割して情報を管理します。ちょうどExcelのシートをイメージ
してもらえればよいかと思います。テーブルには行があり、行単位でデータを追加したり削除します。
また、行にはカラム(列)ごとにどのようなデータを保存するか事前に決める必要があります。
Laravel では Migration という仕組みを使ってテーブル作ります。
ここのファイルはコマンド$ php artisan make:migration create_news_tableで作成される。
2019_06_04_073210_create_profiles_tableと似てる*/


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            /*中にあったbigIncrements('id');はbigを消してincrementsにしたがbigIncrementsでも大丈夫。
            timestamps();は元々あり、titleとbodyとimage_pathを追記、
            PHP/Laravel.14。関数upには、マイグレーション実行時のコードを書きますここでは、id(主キー)、title、body、image_path、
            timestampsの５つのカラムを持つ、newsというテーブルを作成しています。image_pathの右側にある、->nullable()という記述は
            、画像のパスは空でも保存できます、という意味です。つまり、他の４つは全て、保存時に必ず値が入るカラムに設定される、
            ということです。idとtimestampsはレコードが新規作成される際に自動で埋まりますし、titleとbodyは入力時に必須チェック
            をしていますから、必ず値が入ることになりますね。また、関数downには、マイグレーションの取り消しを行う為のコードを
            書きます。ここでは、もしnewsというテーブルが存在すれば削除する、と書かれています。
            次にマイグレーションを実行コマンド$ php artisan migrateを打つ。
            ●補足、テーブル名やカラム名、データ型などが間違っていても、あわてることはありません。直前のマイグレーション操作を
            取り消すことができます。これをロールバックと言います $ php artisan migrate:rollback。
            newsテーブルが作成される前の状態に戻りました。ここで先ほどのマイグレーションファイルに修正がある場合は正しく改修
            して、マイグレーションを再実行して下さい。(migtationsフォルダのファイル修正した場合はrollbackして
            毎回$ php artisan migrateを打たないとダメ。詳しくはスクリーンショット。)*/
            $table->increments('id');//主キー同じ値にならない、各データ、それぞれを識別するためのデータ。必ず必要でおもに('id')になる。
            $table->string('title'); // ニュースのタイトルを保存するカラム(列又はデータベースに入っているデータの項目)
            $table->string('body');  /* ニュースの本文を保存するカラム。app/News.phpと
            resources/lang/ja/validation.php(一応だが日本語化した場所)とid、title、body繋がってる！*/
            $table->string('image_path')->nullable(); 
            /*画像のパスを保存するカラム、nullable()という記述は、画像のパスは
            空でも保存できます、という意味*/
            //日時が入るカラム、基本的に入れる。自動で作成される。
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
        Schema::dropIfExists('news');
    }
}
