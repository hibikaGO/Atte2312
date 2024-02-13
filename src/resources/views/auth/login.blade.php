@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
    <div class="login_title">
        <h2>
            ログイン
        </h2>
    </div>
    <div class="login_content">
        <form action="/login" method="post">
        @csrf
            <div class="login_item">
                <input type="email" name="email" placeholder="メールアドレス">
            @error('email')
            {{ $message }}
            @enderror
            </div>
            <div class="login_item">
                <input type="password"  name="password" placeholder="パスワード">
            @error('password')
            {{ $message }}
            @enderror
            </div>
            <div class="button_login">
                <button type=submit class="login">ログイン</button>
            </div>
        </form>
        <div class="login_text">
            アカウントをお持ちでない方はこちら
        </div>
        <div class="link_register">
            <a href="/register">会員登録</a>
        </div>

    </div>
@endsection