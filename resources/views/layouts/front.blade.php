{{-- PHP/Laravel 18 一般ユーザー用のフロント部分を開発するため書いた。
コマンドで$ cp resources/views/layouts/admin.blade.php resources/views/layouts/front.blade.php
と打てばadmin.blade.php をコピーしてfront.blade.php を作成することができる。
次はフロント用のcssを作成するために、resources/sass/front.scss を作成します。--}}

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        {{-- --windowsの基本ブラウザであるedgeに対応するという記載。
        ぶっちゃけとりあえず書く呪文みたいなものという認識でOKです。 --}}
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        {{-- 画面幅を小さくしたとき、例えばスマートフォンで
        見たときなどに文字や画像の大きさを調整してくれるタグです。 --}}
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
         {{-- 後の章で説明します --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">

         {{-- 各ページごとにtitleタグを入れるために@yieldで空けておきます。
        「@◯◯」という記載のところは、メソッドを読み込んでいます。
        ＠yield と書かれている箇所が2つありますが、あとから作成するbladeファイルで
        各＠yieldの中にテキストやコンテンツを埋め込みます。今回であれば、titleというセッションの内容を表示します。
        上のコメントに書いてある通り、各ページ毎にタイトルを変更できるようにするためです。
        --}}
        <title>@yield('title')</title>

        <!-- Scripts -->
         {{-- Laravel標準で用意されているJavascriptを読み込みます。httpでアクセスしてしまうためcss効かずエラーが出てしまう
         assetに,trueを付けることでhttpsで接続できるようになる。asset(‘ファイルパス’)は、publicディレクトリの
        パスを返す関数のことです。要するに、「/js/app.js」というパスを生成します。 --}}
        <script src="{{ asset('js/app.js',true) }}" defer></script>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        {{-- Laravel標準で用意されているCSSを読み込みます。httpでアクセスしてしまうためcss効かずエラーが出てしまう
         assetに,trueを付けることでhttpsで接続できるようになる --}}
        <link href="{{ asset('css/app.css',true) }}" rel="stylesheet">
        {{-- PHP/Laravel 18で追加CSSを読み込みます。{{ asset('css/admin.css') }}はadmin.blade.phpではあったが
        ここでは削除して以下を記載した--}}
        <link href="{{ asset('css/front.css,true') }}" rel="stylesheet">
        
    </head>
    <body>
        <div id="app">
            {{-- 画面上部に表示するナビゲーションバーです。 --}}
            <nav class="navbar navbar-expand-md navbar-dark navbar-laravel">
                <div class="container">
                     {{-- URLを返すメソッド。これもassetと似たような関数で、configフォルダのapp.phpの中にあるnameに
                        アクセスをします。基本的にはアプリケーションの名前「Laravel」が格納されています --}}
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                    {{-- ボタンはHTMLで書いてる --}}
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    {{-- idは1つclassは複数でOKわけるためにある --}}
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">

                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            {{-- 画面上部のナビゲーションバーにログインリンクやログアウトリンクを設置したいため、以下を追記した --}}
                        <!-- Authentication Links -->
                        {{-- ログインしていなかったらログイン画面へのリンクを表示 --}}
                        @guest
                            <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                        {{-- ログインしていたらユーザー名とログアウトボタンを表示 --}}
                        @else
                            <li class="nav-item dropdown">
                                {{-- Auth::userは現在認証されているユーザーの取得 --}}
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
                                {{-- ログアウトボタン表示 --}}
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    {{-- methodは通信形式基本はgetはユーザー見える、posはユーザーに見えないように渡す --}}
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            @endguest
                            {{-- 画面上部のナビゲーションバーにログインリンクやログアウトリンクを設置したいため以上までを追記 --}}
                        </ul>
                    </div>
                </div>
            </nav>
            {{-- ここまでナビゲーションバー --}}

            <main class="py-4">
                {{-- コンテンツをここに入れるため、@yieldで空けておきます。news/create.blade.phpや
                profile/create.blade.phpなどに読まれる --}}
                @yield('content')
            </main>
            
            
        </div> {{--app end --}}
    </body>
</html>