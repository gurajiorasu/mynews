{{-- extends('layouts.admin')でlayouts/admin.blade.phpを読み込む。layoutフォルダ作成し、そこに全てのページに共通する部分
を記述する。簡単にいうと、テンプレート（viewファイル）の継承（読み込み）を行うメソッドです。コメントにあるように
読みこむというのは、要するに置き換わるという認識になります。@extends大本のviewlayouts.admin'が親ですよ--}}
@extends('layouts.admin')


{{-- admin.blade.phpの@yield('title')に'ニュースの新規作成'を埋め込む。
＠sectionは、名前が示す通りにコンテンツのセクションを定義します。具体的な動作は、コメントに書いてある通り
「admin.blade.phpの@yield('title')に'ニュースの新規作成'を埋め込む」が動作します。
@sectionと@yieldを付ければ自動で繋がるようになる！
埋め込むという文章はその部分を置き換えることを意味しています。例えば、@yield('title')は
@section('title', 'ニュースの新規作成')に置き換わるので、@yield('title') -> ニュースの新規作成になります
つまり上のタイトル(タブのところ)を置き換える。
->はPHPプログラムのアロー演算子は左辺から右辺を取り出す演算子、例)例えばクラス「AAA」には3つの下記のような要素を
持っているとする xxx=イノシシ yyy=シカ zzz=チョウ　AAA->xxxはイノシシとなるわけです。--}}

@section('title', 'ニュースの新規作成画面')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む@yieldは予約語,@yield('content')でcontentで置き換える。
@yieldは複数あっても大丈夫、('content')や上の('title')で違い付けてる。@sectionと@yieldを付ければ自動で繋がる
こちらも同様に、「admin.blade.phpの@yield('content')に以下のタグを埋め込む」という動作を行います。yieldとsectionセットで使う--}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>ニュース新規作成</h2>
                
                {{-- formはPHP/Laravel 13で追加 --}}
                <form action="{{ action('Admin\NewsController@create') }}" method="post" enctype="multipart/form-data">
                    {{-- count($errors)、$errors` は `validate` で弾かれた内容を記憶する配列のことでしたね。
                    countメソッドは配列の個数を返すメソッドになっています。
                    もし、エラーがなければ$errorsはnullを返すのでcount($errors)は0を返します。
                    バリデーションでエラーを見つけたときには、Laravel が自動的に $errors という変数にエラーを格納します。
                    ＄errors は配列で、その要素がある場合はエラーと見なし、エラーメッセージを表示します。
                    エラーメッセージを日本語化するために、まず、config/app.php で ‘locale’ を指定している箇所を編集し、
                    ’en’ から ‘ja’ に変更します--}}
                    @if (count($errors) > 0)
                        <ul>
                            {{-- foreachは配列の数だけループする構文になっています。つまり、$errorsの中身の数だけループし、
                            その中身を$eに代入しています。$eに代入された中身を次の文で表示しているわけです。
                            ＜li＞{{ $e }}＜/li＞実の所、このセクションでは入力したデータを保存するコードを書いていないので、
                            エラーメッセージは表示されません。次章以降のモデルの設定が完了したら、どのようなエラーメッセージが
                            出るか確認しましょう！
                            ループは複数のニュースの情報を１つの画面に表示させたいがため、配列としてviewに渡し、その配列をloop
                            させながら1件1件の情報をタグとして表示させたいケース（ニュース一覧のような、～一覧画面で使われる
                            事が多いです）--}}
                            @foreach($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="form-group row">
                        {{--＜LABEL＞タグはフォームの構成部品（一行テキストボックス・チェックボックス・ラジオボタン等）と、
                        その項目名（ラベル）を明確に関連付けるための要素で、＜label for="id属性値"＞で使う。
                        関連付けを行うことにより、ブラウザでラベル（もしくはラベルのアクセスキー）をクリックした際に、
                        その構成部品をクリックしたのと同じ動作が可能になります。おそらくfor="title"以下の"body"は
                        2019~create_news_table.phpとapp/News.phpと一応だが日本語化した場所resources/lang/ja/validation.phpと繋がってる--}}
                        <label class="col-md-2" for="title">タイトル</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2" for="body">本文</label>
                        <div class="col-md-10">
                            {{-- textareaは複数行のテキスト入力欄を作成する(htmlタグ)。rowsは入力欄の高さを行数で指定(htmlタグ) --}}
                            <textarea class="form-control" name="body" rows="20">{{ old('body') }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2" for="title">画像</label>
                        <div class="col-md-10">
                            <input type="file" class="form-control-file" name="image">
                        </div>
                    </div>
                    {{-- {{ csrf_field() }}と記述することでそのランダムな文字列をタグとして持たせることができます。
                    csrf攻撃(SSHに近いかも)というものの対策として、Laravelがランダムな文字列をviewを表示する際にタグ
                    として持っておいて、その文字列をサーバーに送信させてサーバー側でその文字列が、view表示時に作成した
                    ランダムな文字列と一致するかチェックすることでcsrf攻撃を防ぐ仕組みを提供してくれている。
                    付けるとこはformから、ユーザーが何かを入力して post送信（これの送信がボタンになっていることが多い）する時に
                    付けるイメージになります。--}}
                    {{ csrf_field() }}
                    <input type="submit" class="btn btn-primary" value="更新">
                </form>
                
            </div>
        </div>
    </div>
@endsection


