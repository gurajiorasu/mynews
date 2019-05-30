<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    /*以下のadd, create, edit, update それぞれのActionを追加(課題)。
    public function add(),public function edit()のviewはweb.phpとつながってる。*/
      public function add()
  {
      return view('admin.profile.create'); //PHP/Laravel 10の課題4.resources/views/admin/profileフォルダにcreate.blade.php作成？。
  }

  public function create()
  {
      return redirect('admin/profile/create');
  }

 public function edit()
 {
 return view('admin.profile.edit'); //PHP/Laravel 10の課題4.resources/views/admin/profileフォルダにedit.blade.php作成？。
 }
 public function update()
 {
 return redirect('admin/profile/edit');
 }
}
