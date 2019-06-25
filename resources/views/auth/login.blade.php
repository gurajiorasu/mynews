{{-- ここはPHP/Laravel 12でコマンド$ php artisan make:auth と $ php artisan migrate実行でControllerやView、Routingの設定まで
自動で行ってくれます。ただしViewに関してはデザインを前の章で作ったものに合わせたいため、以下編集した。
「__(‘Login’)」という構文が出てきます。この「__」は、ヘルパ関数（viewで使うための関数）の一種で、翻訳文字列の取得として
使われます、下に説明書いてる。resources/langの中に、多言語対応できるようにファイルを作成して使います。config/app.phpの'locale'をjaに変更。
messages.phpのファイルの中身を読むためにヘルパー関数を編集する、｛｛_(‘ ◯◯ ‘) ｝｝のところを｛｛_(‘ messages.◯◯ ‘) ｝｝
にする、例｛｛_(' login ') ｝｝→　｛｛_(' messages.login ') ｝｝にする16行目あたり。
最後に、サーバーを再起動してログイン画面を開いてみてください。/loginのとこ。英語だった文字が日本語化されていると思います。 --}}

@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="login-box card">
                    {{-- messages.phpファイルから読み込めるように、Loginのとこをmessages.Loginにした。
                    つまり messages.phpに'Login' => 'ログイン',と変えたために日本語でログインと/login画面に表示される
                    __はヘルパ関数で翻訳キーが存在しなければ(ja/messages.phpに記載がない)、__関数はmessages.Loginを返します--}}
                    <div class="login-header card-header mx-auto">{{ __('messages.Login') }}</div>
                    <div class="login-body card-body">
                        {{-- route関数は、URLを生成したりリダイレクトしたりするための関数です。今回であれば、
                        ”/login”というURLを生成しています。＠csrfこれは、認証済みのユーザーがリクエストを送信しているのかを確認するために
                        利用します。アプリケーションでHTMLフォームを定義する場合は常に、CSRF保護ミドルウェアがリクエストを検証できるように
                        隠しCSRFトークンフィールドをそのフォームへ含める必要があります。このトークンを生成するのが＠csrf。
                        詳しい説明url https://readouble.com/laravel/5.6/ja/csrf.html--}}
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group row">
                                {{-- 以下のmessagesは上同様の説明 --}}
                                <label for="email" class="col-sm-4 col-form-label text-md-right">{{ __('messages.E-Mail Address') }}</label>
                                <div class="col-md-6">
                                    {{-- 少し複雑かもしれませんが、三項演算子という手法を使っています。三項演算子とは、if文を1行で
                                    書いたようなもので、次のような使い方します。<条件式> ? <真式> : <偽式>あ
                                    例）a == 1 ? “aは１です。” : “aは１ではありません。”
                                    aが1のとき、条件式は真(true)なので、”aは１です。”が出力される。aが1ではないとき、 条件式は偽(false)なので、
                                    ”aは１ではありません。”が出力される。このように、条件式がfalseまたはNULL(値に何もない)の時は、:の右側が実行され、
                                    そうでない時は、:の左側が実行されます。今回の場合、何もエラーがなければ$errors->has('email') の値はNULLになる
                                    ので:の右側が表示されます （何も記載がないので実際は表示されない）。もし、エラーがある場合には
                                    $errors->has('email') の値にエラーメッセージが代入されるので、” is-invalid”が出力されます。
                                    まとめ、三項演算子は
                                    ()内の結果が正しい(true)場合、 :より左側が代入され、()内の結果が間違っている(false)場合は:より右側が代入される。
                                    old('email')とはold('フォームのキー名')このoldヘルパ関数は、セッションにフラッシュデータ（一時的にしか保存されない
                                    データ）として入力されているデータを取得することができます。今回の場合のフラッシュデータとは、直前までユーザーが
                                    入力していた値のことを指します。直前のデータがない場合は、nullを返します。つまりこれはタイトルや本文を入力していて
                                    画面が切り替わり戻っても、消えずに文章が残っているということ。--}}
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                                    
                                    {{-- ＄errors->has('email')は＄errorsというのは、バリデーション（後述）で返された時に代入されるメッセージが
                                    格納されています。 $errors` は `validate` で弾かれた内容を記憶する配列のこと。要するに、そのままエラーメッセージが
                                    格納されている変数。
                                    has(‘email’)は、emailフィールド（のこと）で発生したエラー内容という意味になり、もしこのemailでエラーが起きていると
                                    その内容を取得することができる。->はPHPプログラムのアロー演算子は左辺から右辺を取り出す演算子、
                                    例)例えばクラス「AAA」には3つの下記のような要素を持っているとする xxx=イノシシ yyy=シカ zzz=チョウ
                                    AAA->xxxはイノシシとなるわけです--}}
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback">
                                            //firstとは変数$errorsに格納されているデータの1番目を指します。つまり、$errors[0]をさします。
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('messages.Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                                    
                                    
                                    {{-- @ifと@endifは、phpのif文を意味しています。条件式の中身は、($errors->has('email'))になっていますね
                                    先ほどいったように、エラーがあればエラーメッセージを、なければnull(値に何もない)を返すようになっています。
                                    もしエラーメッセージがあれば、if文の中身を実行し、実際にメッセージの内容を表示します。nullであればif文の中身は実行されず、
                                    何も表示されません。 --}}
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="checkbox">
                                        <label>
                                            {{-- テキストにもあるように、多言語対応するためのヘルパ関数になります。翻訳用のファイルに'Remember Me'に
                                            置き換える単語なり文章を登録することで、自動的に登録した文言に置き換わります。例えば日本語向けの翻訳用
                                            ファイルを用意すれば'Remember Me'が日本語の文言に、英語向けの翻訳用ファイルを用意すれば'Remember Me'が
                                            英語の文言に切り替わります。--}}
                                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('messages.Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Login') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection