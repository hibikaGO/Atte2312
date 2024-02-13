@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/users.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@endsection

@section('header')
    <div class="header_link">
        <div class="link_item">
            <a href="/" class="link_home">HOME</a>
        </div>
        <div class="link_item">
            <a href="/attendance" class="link_attendance">日付一覧</a>
        </div>
        <div class="link_item">
            <a href="/users" class="link_attendance">ユーザー一覧</a>
        </div>
        <div class="link_item">
            <form class="form" action="/logout" method="post">
            @csrf
                <button class="header-nav__button">
                    ログアウト
                </button>
            </form>
        </div>
    </div>
@endsection
@section('content')
    <div class="users content">
        <h2 class="title">ユーザー一覧</h2>
        @foreach($users as $user)
        <div class="users">
            <a href="{{ route('personal', $user->id) }}" class="users_name">{{ $user->name }}</a>
        </div>
        @endforeach
    </div>
@endsection