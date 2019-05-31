{{-- layouts/admin.blade.phpを読み込む。
簡単にいうと、テンプレート（viewファイル）の継承（読み込み）を行うメソッドです。コメントにあるように
layouts/admin.blade.phpを読み込みます。読みこむというのは、要するに置き換わるという認識になります。--}}
@extends('layouts.admin')


{{-- admin.blade.phpの@yield('title')に'ニュースの新規作成'を埋め込む。
＠sectionは、名前が示す通りにコンテンツのセクションを定義します。具体的な動作は、コメントに書いてある通り
「admin.blade.phpの@yield('title')に'ニュースの新規作成'を埋め込む」が動作します。--}}
@section('title', 'ニュースの新規作成')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>ニュース新規作成</h2>
            </div>
        </div>
    </div>
@endsection
{{-- こちらも同様に、「admin.blade.phpの@yield('content')に以下のタグを埋め込む」という動作を行います。--}}