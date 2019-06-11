<?php
/*PHP/Laravel 17課題2でタイトルの名前任意で付けた。
コマンド$php artisan make:migration create_histories_table で作成。
モデルはテーブルと連携しているので、新しくテーブルを作成する際はそれに対応するモデルの作成が必要です。
その後、コマンド$php artisan migrateした*/

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfileHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //create(profile_historiesは自動で付いた
        Schema::create('profile_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('profile_id');
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
        Schema::dropIfExists('profile_histories');
    }
}
