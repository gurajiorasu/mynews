{{-- ここはViewを実装するため右クリックでファイル作成した、PHP/Laravel 15 --}}
@extends('layouts.admin')
@section('title', '登録済みニュースの一覧')

@section('content')
    <div class="container">
        <div class="row">
            <h2>ニュース一覧</h2>
        </div>
        <div class="row">
            <div class="col-md-4">
                <a href="{{ action('Admin\NewsController@add') }}" role="button" class="btn btn-primary">新規作成</a>
            </div>
            <div class="col-md-8">
                <form action="{{ action('Admin\NewsController@index') }}" method="get">
                    <div class="form-group row">
                        <label class="col-md-2">タイトル</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="cond_title" value="{{ $cond_title }}">
                        </div>
                        <div class="col-md-2">
                            {{ csrf_field() }}
                            <input type="submit" class="btn btn-primary" value="検索">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="list-news col-md-12 mx-auto">
                <div class="row">
                    <table class="table table-dark">
                        <thead>
                            <tr>
                                <th width="10%">ID</th>
                                <th width="20%">タイトル</th>
                                <th width="50%">本文</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- ここで初めて出てくるメソッドはstr_limit()になります。他のメソッドは前に出てる。
                            str_limit()は、文字列を指定した数値で切り詰めるというメソッドになります。ただ、注意して
                            ほしいのは切り詰める文字の数は半角で認識するようになっています。全角の文字は2文字として
                            認識されます。例）str_limit(“2018/12/13”,7)#結果は、「2018/12」。
                            str_limit(“2018年12月13日”,7)#結果は、「2018年1」。str_limit($news->title, 100)は、
                            もしタイトルが全て全角なら最大50文字まで表示することになります。＠foreach を使って取得した
                            データの一つ一つを処理し、各データの id と名前、メールアドレスを表示しています。
                            ＠foreach は PHP の foreach ではなく blade の構文ですが、使用方法に大きな差はありません。--}}
                            @foreach($posts as $news)
                                <tr>
                                    <th>{{ $news->id }}</th>
                                    <td>{{ str_limit($news->title, 100) }}</td>
                                    <td>{{ str_limit($news->body, 250) }}</td>
                                    {{--編集リンク＆削除リンクを表示するように追加＜td＞から＜/td＞まで、PHP/Laravel 16 --}}
                                    <td>
                                        <div>
                                            <a href="{{ action('Admin\NewsController@edit', ['id' => $news->id]) }}">編集</a>
                                        </div>
                                        <div>
                                            <a href="{{ action('Admin\NewsController@delete', ['id' => $news->id]) }}">削除</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection