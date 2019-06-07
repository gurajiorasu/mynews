{{--PHP/Laravel 11.課題4.create.blade.php ファイルを作成し、3. で作成した profile.blade.phpファイルを読み込み、
また プロフィールのページであることがわかるように titleとcontentを編集しましょう。
views/admin/news/create.blade.phpを参考にする。--}}
@extends('layouts.profile')


{{-- admin.blade.phpの@yield('title')に'ニュースの新規作成'を埋め込む。
＠sectionは、名前が示す通りにコンテンツのセクションを定義します。具体的な動作は、コメントに書いてある通り
「admin.blade.phpの@yield('title')に'ニュースの新規作成'を埋め込む」が動作します。＜title＞@yield('title')＜/title>＞
がよまれる--}}
@section('title', 'プロフィールページ')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む@yieldは予約語,@yield('content')でcontentで置き換える。
@yieldは複数あっても大丈夫、('content')や上の('title')で違い付けてる --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>プロフィールページ</h2>
                
                {{-- formはPHP/Laravel 13課題4で追加。admin/news/create.blade.phpを参考にした。 --}}
                {{-- formの送信先(＜form action=”この部分”＞)を、 Admin\ProfileController の create Action に指定した --}}
                <form action="{{ action('Admin\ProfileController@create') }}" method="post" enctype="multipart/form-data">
                    {{-- count($errors)$errors` は `validate` で弾かれた内容を記憶する配列のことでしたね。
                    countメソッドは配列の個数を返すメソッドになっています。
                    もし、エラーがなければ$errorsはnullを返すのでcount($errors)は0を返します。
                    バリデーションでエラーを見つけたときには、Laravel が自動的に $errors という変数にエラーを
                    格納します。$errors は配列で、その要素がある場合はエラーと見なし、エラーメッセージを表示します--}}
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
                        <label class="col-md-2" for="name">氏名</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2" for="gender">性別</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="gender" value="{{ old('gender') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2" for="hobby">趣味</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="hobby" value="{{ old('hobby') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2" for="introduction">自己紹介欄</label>
                        <div class="col-md-10">
                            {{-- textareaは複数行のテキスト入力欄を作成する(htmlタグ)。rowsは入力欄の高さを行数で指定(htmlタグ) --}}
                            <textarea class="form-control" name="body" rows="10">{{ old('body') }}</textarea>
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