<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewsController extends Controller
{
    /*以下を追記しAction追加。ActionとはLaravel特有の言葉で、Controllerが持つ機能のことを指します。
    具体的には、Controller内に実装した関数(厳密にはメソッドといいます) のことを指します*/
     public function add()
  {
      return view('admin.news.create');
      /*NewsControllerに、addというActionを実装することができました。しかし残念ながらまだこのActionは使用されません。
      理由としては、Routingの設定をしないとこのActionを使われることが無いからです。
      その後。Routing(web.phpに)設定後、view(‘admin.news.create’);これは、admin/newsディレクトリ配下のcreate.blade.html 
      というファイルを呼び出すという意味です。つまり、resources/views/admin/newsディレクトリ配下に
      create.blade.htmlファイルを作成する必要があるということになります*/
  }
    
    
}
