@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="register_title">
    <h2>
        会員登録
    </h2>
</div>
<div class="register_content">
    <form action="/register" method="post">
        @csrf
        <div class="register_item">
            <input type="text" name="name" placeholder="お名前">
            @error('name')
            {{ $message }}
            @enderror
        </div>
        <div class="register_item">
            <input type="email" name="email" placeholder="メールアドレス">
            @error('email')
            {{ $message }}
            @enderror
        </div>
        <div class="register_item">
            <input type="password" name="password" placeholder="パスワード">
            @error('password')
            {{ $message }}
            @enderror
        </div>
        <div class="register_item">
            <input type="password" name="password_confirmation" placeholder="確認用パスワード">
        </div>
        <div class="button_register">
            <button type=submit class="register">登録</button>
        </div>
    </form>
    <div class="register_text">
        すでにアカウントをお持ちの方はこちらからログインしてください
    </div>
    <div class="link_login">
        <a href="/login">ログイン</a>
    </div>
</div>
@endsection
