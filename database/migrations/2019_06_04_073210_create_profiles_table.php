<?php
//コマンド $ php artisan make:migration create_profiles_table でMigrationを作成。22019_06_04_000614_create_news_table.phpと似てる

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*以下はPHP/Laravel 14.課題4で作成。Schema::create('profiles',は自動でprofilesになった。
        おそらくコマンドでcreate_profiles_table打ったから、↑にコマンド書いてる。
        reate_profiles_table というMigrationの雛形ファイルを作成し、 profilesというテーブル名で名前(name)、
        性別(gender)、趣味(hobby)、自己紹介(introduction)を保存できるように修正して、 migrateしてテーブルを作成する*/
        Schema::create('profiles', function (Blueprint $table) {
            
            $table->string('name');  // プロフィールの名前(name)を保存するカラム
            $table->string('gender');  // プロフィールの性別(gender)を保存するカラム
            $table->string('hobby)');  // プロフィールの趣味(hobby)を保存するカラム
            $table->string('introduction'); // プロフィールの自己紹介(introduction)を保存するカラム
            $table->string('image_path')->nullable(); /*画像のパスを保存するカラム、nullable()という記述は、画像のパスは
            空でも保存できます、という意味*/
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
        Schema::dropIfExists('profiles');
    }
}
