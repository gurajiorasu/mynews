{{--PHP/Laravel 11.課題4.create.blade.php ファイルを作成し、3. で作成した profile.blade.phpファイルを読み込み、
また プロフィールのページであることがわかるように titleとcontentを編集しましょう。
views/admin/news/create.blade.phpを参考にする。--}}
@extends('layouts.profile')


{{-- admin.blade.phpの@yield('title')に'ニュースの新規作成'を埋め込む。
＠sectionは、名前が示す通りにコンテンツのセクションを定義します。具体的な動作は、コメントに書いてある通り
「admin.blade.phpの@yield('title')に'ニュースの新規作成'を埋め込む」が動作します。
上記はnews/create.blade.phpの内容、以下'プロフィールページ'は変えた。--}}
@section('title', 'プロフィールページ')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>プロフィールページ</h2>
            </div>
        </div>
    </div>
@endsection
{{-- こちらも同様に、「admin.blade.phpの@yield('content')に以下のタグを埋め込む」という動作を行います。--}}