{{-- ここは右クリックで作成PHP/Laravel 16.課題3 投稿したニュースを更新/削除しよう。profile/edit.blade.php
を参考に作成。
edit（編集画面）のURLを確認する場合、admin/profile/edit?id=2 などでid変えて確認できる--}}
@extends('layouts.profile')
@section('title', 'プロフィールページ')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>プロフィール編集</h2>
                {{-- Admin\ProfileController@updateはformの送信先 --}}
                <form action="{{ action('Admin\ProfileController@update') }}" method="post" enctype="multipart/form-data">
                    @if (count($errors) > 0)
                        <ul>
                            @foreach($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="form-group row">
                        <label class="col-md-2" for="title">氏名</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="name" value="{{ $profile_form->name }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2" for="body">性別</label>
                        <div class="col-md-10">
                            <input class="form-control" name="gender" value="{{ $profile_form->gender }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2" for="body">趣味</label>
                        <div class="col-md-10">
                            <input class="form-control" name="hobby" value="{{ $profile_form->hobby }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2" for="body">自己紹介欄</label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="introduction" rows="20">{{ $profile_form->introduction }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2" for="image">画像</label>
                        <div class="col-md-10">
                            <input type="file" class="form-control-file" name="image">
                            <div class="form-text text-info">
                                設定中: {{ $profile_form->image_path }}
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" name="remove" value="true">画像を削除
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-10">
                            <input type="hidden" name="id" value="{{ $profile_form->id }}">
                            {{ csrf_field() }}
                            <input type="submit" class="btn btn-primary" value="更新">
                        </div>
                    </div>
                </form>
                {{-- PHP/Laravel 17課題2で記録した変更履歴を編集画面で参照できるようにします、以下追加 --}}
                <div class="row mt-5">
                    <div class="col-md-4 mx-auto">
                        <h2>編集履歴</h2>
                        <ul class="list-group">
                            @if ($profile_form->histories != NULL)
                                @foreach ($profile_form->histories as $history)
                                    <li class="list-group-item">{{ $history->edited_at }}</li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection