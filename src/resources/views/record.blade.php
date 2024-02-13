@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/record.css') }}">
@endsection

@section('header')
    <div class="header_link">
        <div class="link_item">
            <a href="/" class="link_home">ホーム</a>
        </div>
        <div class="link_item">
            <a href="/attendance" class="link_home">日付一覧</a>
        </div>
        <div class="link_item">
            <a href="/users" class="link_home">ユーザー一覧</a>
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
    <div class="record_title">
        @if(Auth::check())
        <h2>
            {{ Auth::user()->name }} さん、お疲れ様です！
        </h2>
        @endif
    </div>
    <div class="record_content">
        <div class="button_row">
            <div class="button_record">
            @if ($showStartWorkButton)
                <form method="POST" action="/record/start">
                @csrf
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                    <input type="hidden" name="start_time" value="{{ now() }}">
                    <button type="submit"class="button_record_button">勤怠開始</button>
                </form>
            @else
                <button class="hidden_button">勤怠開始</button>
            @endif
            </div>
            <div class="button_record">
            @if ($showEndWorkButton)
                <form method="POST" action="/record/end">
                @csrf
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                    <input type="hidden" name="end_time" value="{{ now() }}">
                    <button type="submit"class="button_record_button">勤怠終了</button>
                </form>
            @else
                <button class="hidden_button">勤怠終了</button>
            @endif
            </div>
        </div>
        <div class="button_row">
            <div class="button_record">
            @if ($showStartBreakButton)
                <form method="POST" action="/record/break/start">
                @csrf
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                    <input type="hidden" name="break_start_time" value="{{ now() }}">
                    <button type="submit" class="button_record_button">休憩開始</button>
                </form>
            @else
                <button class="hidden_button">休憩開始</button>
            @endif
            </div>
            <div class="button_record">
            @if ($showEndBreakButton)
                <form method="POST" action="/record/break/end">
                @csrf
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                    <input type="hidden" name="break_end_time" value="{{ now() }}">
                    <button type="submit"class="button_record_button">休憩終了</button>
                </form>
            @else
                <button class="hidden_button">休憩終了</button>
            @endif
            </div>
        </div>
    </div>

@endsection