{{-- layout.blade.phpというファイルを作成し、そこに全てのページに共通する部分を記述し、また各ページごとに異なる部分（コンテンツ）
をあとで埋め込むように空けておきます。その後、a.blade.phpといったファイルからlayout.blade.phpを呼び出し、空けておいた部分に
ページのコンテンツを埋め込むことで、完成されたページが出力されます。そうすることで、先程のロゴの修正が発生した場合などは
layout.blade.phpを編集することで全体が書き換わります。layoutsフォルダにadmin.blade.phpファイルを作り以下書いた。
｛｛｝｝ についてまず全体として、｛｛｝｝で囲まれたコードは、PHPで書かれた内容を表示するという意味になります。
より簡単に言えば、｛｛｝｝の中身を文字列に置換し、htmlの中に記載するということです。
ブラウザの実行はコマンドで $ cd ~/environment/mynews その後 $ npm run watch その後Control + Cで止めて
、$ php artisan serve --port=8080 を打ちLaravelサーバーを起動し、ブラウザで/admin/news/create にアクセスする--}}

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
        上のコメントに書いてある通り、各ページ毎にタイトルを変更できるようにするためです。--}}
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
        {{-- この章の後半で作成するCSSを読み込みます --}}
        <link href="{{ asset('css/admin.css',true) }}" rel="stylesheet">
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
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

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

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

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
                {{-- コンテンツをここに入れるため、@yieldで空けておきます。 --}}
                @yield('content')
            </main>
            
            
        </div> {{--app end --}}
    </body>
</html>