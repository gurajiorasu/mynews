{{-- ここはViewを実装するため右クリックでファイル作成した、PHP/Laravel 15 --}}
@extends('layouts.profile')
@section('title', '登録済みプロフィール一覧')

@section('content')
    <div class="container">
        <div class="row">
            <h2>プロフィール一覧</h2>
        </div>
        <div class="row">
            <div class="col-md-4">
                {{-- 新規作成クリックでAdmin\NewsControllerのアクションaddにいく。また実際のHPで新規作成クリックで
                admin/news/createページに飛ぶ--}}
                <a href="{{ action('Admin\ProfileController@add') }}" role="button" class="btn btn-primary">新規作成</a>
            </div>
            <div class="col-md-8">
                {{-- Admin\NewsController@indexはformの送信先 --}}
                <form action="{{ action('Admin\ProfileController@index') }}" method="get">
                    <div class="form-group row">
                        <label class="col-md-2">タイトル</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="cond_title" value="{{ $cond_title }}">
                        </div>
                        <div class="col-md-2">
                            {{-- {{ csrf_field() }}と記述することでそのランダムな文字列をタグとして持たせることができます。
                            csrf攻撃(SSHに近いかも)というものの対策として、Laravelがランダムな文字列をviewを表示する際にタグ
                            として持っておいて、その文字列をサーバーに送信させてサーバー側でその文字列が、view表示時に作成した
                            ランダムな文字列と一致するかチェックすることでcsrf攻撃を防ぐ仕組みを提供してくれている。
                            付けるとこはformから、ユーザーが何かを入力して post送信（これの送信がボタンになっていることが多い）
                            する時に付けるイメージになります。--}}
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
                                <th width="10%">氏名</th>
                                <th width="10%">性別</th>
                                <th width="20%">趣味</th>
                                <th width="30%">自己紹介欄</th>
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
                            Bladeテンプレートで配列のループを使用したい時は＠foreachを使いループでキーを使用する事が出来ます。
                            ＠foreach は PHP の foreach ではなく blade の構文ですが、使用方法に大きな差はありません。--}}
                            @foreach($posts as $profile)
                                <tr>
                                    <th>{{ $profile->id }}</th>
                                    <td>{{ str_limit($profile->name, 100) }}</td>
                                    <td>{{ str_limit($profile->gender, 100) }}</td>
                                    <td>{{ str_limit($profile->hobby, 100) }}</td>
                                    <td>{{ str_limit($profile->introduction, 250) }}</td>
                                    {{--編集リンク＆削除リンクを表示するように追加＜td＞から＜/td＞まで、PHP/Laravel 16 --}}
                                    <td>
                                        <div>
                                            {{-- 編集リンクを表示する。
                                            =>(ダブルアロー演算子)は連想配列の　例)$animals = ["cat" => "猫","dog" => "犬",];　
                                            "cat" というキーで "猫"という値を保持しますよ、という key と value(animals) をつなぐもの
                                            PHPの連想配列では、「=>」という記号を使う、というものですね。
                                            ダブルアロー演算子は変数に対する値を表します。つまり、`['id' => $news->id]`はidに対する値は
                                            $news->idである、となります。一方、アロー演算子はオブジェクトが持つパラメータやメソッドに
                                            アクセスする際に使用されます。｀$news->id｀は$newsがもつidにアクセスします。--}}
                                            <a href="{{ action('Admin\ProfileController@edit', ['id' => $profile->id]) }}">編集</a>
                                        </div>
                                        <div>
                                            <a href="{{ action('Admin\ProfileController@delete', ['id' => $profile->id]) }}">削除</a>
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