{{-- layouts/admin.blade.phpを読み込む。
簡単にいうと、テンプレート（viewファイル）の継承（読み込み）を行うメソッドです。コメントにあるように
layouts/admin.blade.phpを読み込みます。読みこむというのは、要するに置き換わるという認識になります。--}}
@extends('layouts.admin')


{{-- admin.blade.phpの@yield('title')に'ニュースの新規作成'を埋め込む。
＠sectionは、名前が示す通りにコンテンツのセクションを定義します。具体的な動作は、コメントに書いてある通り
「admin.blade.phpの@yield('title')に'ニュースの新規作成'を埋め込む」が動作します。--}}
@section('title', 'ニュースの新規作成')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む@yieldは予約語,@yield('content')でcontentで置き換える。
@yieldは複数あっても大丈夫、('content')や上の('title')で違い付けてる--}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>ニュース新規作成</h2>
                
                {{-- formはPHP/Laravel 13で追加 --}}
                <form action="{{ action('Admin\NewsController@create') }}" method="post" enctype="multipart/form-data">
                    {{-- count($errors)$errors` は `validate` で弾かれた内容を記憶する配列のことでしたね。
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
                            出るか確認しましょう！--}}
                            @foreach($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="form-group row">
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
                    {{ csrf_field() }}
                    <input type="submit" class="btn btn-primary" value="更新">
                </form>
                
            </div>
        </div>
    </div>
@endsection
{{-- こちらも同様に、「admin.blade.phpの@yield('content')に以下のタグを埋め込む」という動作を行います。--}}