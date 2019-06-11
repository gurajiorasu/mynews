{{-- ここはPHP/Laravel 18で作成。コマンド $ mkdir resources/views/news 作成後に
index.blade.phpを作成した。ここのnewsフォルダは一般ユーザーがニュースを読むためのフロント部分で、
上のフォルダのnewsは投稿者用になる。次はroutes/web.php、ルーティンの設定。
その次は画像の設置場所をLaravelに教えるために次のコマンドを入力します $ php artisan storage:link--}}
@extends('layouts.front')

@section('content')
    <div class="container">
        <hr color="#c0c0c0">
        {{-- is_nullというメソッドは、「nullであればtrue、それ以外であればfalseを返す」というメソッドに
        なっています。そして、「!」は否定演算子と呼ばれ、「true、falseを反転する」という意味を持っています。
        要するに、@if !is_null($headline)は、$headlineが空なら飛ばして（実行しない）、データがあれば
        実行するという意味になります。 --}}
        @if (!is_null($headline))
            <div class="row">
                <div class="headline col-md-10 mx-auto">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="caption mx-auto">
                                <div class="image">
                                    @if ($headline->image_path)
                                        {{-- assetは、「publicディレクトリ」のパスを返すヘルパとなっています。ヘルパとはviewファイル
                                        で使えるメソッドのことです。このメソッドは、現在のURLのスキーマ（httpかhttps）を使い、
                                        アセットへのURLを生成するメソッドになっています。$headline->image_pathは、保存した画像の
                                        ファイル名が入っているんでしたよね。では、「'storage/image/' . $headline->image_path」の
                                        「.」は何を意味するのでしょうか？これは、文字列を結合する結合演算子と呼ばれるものです。
                                        例）
                                        $a = “Hello”;
                                        echo $a . “ World”;
                                        →”Hello World”
                                        つまり、画像のパスを返しているです。これで画像が保存されているパスのURLを生成することができました--}}
                                        <img src="{{ $headline->image_path) }}">
                                    @endif
                                </div>
                                <div class="title p-2">
                                    <h1>{{ str_limit($headline->title, 70) }}</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <p class="body mx-auto">{{ str_limit($headline->body, 650) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <hr color="#c0c0c0">
        <div class="row">
            <div class="posts col-md-8 mx-auto mt-3">
                @foreach($posts as $post)
                    <div class="post">
                        <div class="row">
                            <div class="text col-md-6">
                                <div class="date">
                                    {{-- 以下のformatメソッドは、その名の通りフォーマットするためのメソッドになっています。というのも、
                                    update_atカラムに保存されているデータは、「2018-12-08 08:57:33.0 UTC (+00:00)」という形に
                                    なっているため、そのまま表示すると見づらくなってしまいます。formatメソッドを使えば、簡単に日付の
                                    フォーマットを変更することができます。 --}}
                                    {{ $post->updated_at->format('Y年m月d日') }}
                                </div>
                                <div class="title">
                                    {{ str_limit($post->title, 150) }}
                                </div>
                                <div class="body mt-3">
                                    {{ str_limit($post->body, 1500) }}
                                </div>
                            </div>
                            <div class="image col-md-6 text-right mt-4">
                                @if ($post->image_path)
                                    <img src="{{ $post->image_path) }}">
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr color="#c0c0c0">
                @endforeach
            </div>
        </div>
    </div>
    </div>
@endsection