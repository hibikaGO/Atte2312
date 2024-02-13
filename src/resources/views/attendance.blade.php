@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@endsection

@section('header')
    <div class="header_link">
        <div class="link_item">
            <a href="/" class="link_home">HOME</a>
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
    <div class="attendance_content">
        <div class="date">
            <div class="date_preview">
                <a href="{{ url('/attendance?date=' . $previousDate) }}" class="date_preview_fig">
                    <
                </a>
            </div>
            <div class="date_title">
                <h2>{{ $year }}年{{ $month }}月{{ $day }}日</h2>
            </div>
            <div class="date_next">
                <a href="{{ url('/attendance?date=' . $nextDate) }}" class="date_next_fig">
                    >
                </a>
            </div>
        </div>
        <div class="records_content">
            <table class="records_table">
                <div class="table_header">
                    <tr class="table_header_item">
                        <td class="item-title-name">
                            <div class="item-name">
                                名前
                            </div>
                        </td>
                        <td class="item-title-start">
                            <div class="item-start">
                                勤務開始
                            </div>
                        </td>
                        <td class="item-title-end">
                            <div class="item-end">
                                勤務終了
                            </div>
                        </td>
                        <td class="item-title-break-time">
                            <div class="item-break">
                                休憩時間
                            </div>
                        </td>
                        <td class="item-title-work-time">
                            <div class="item-break">
                                勤務時間
                            </div>
                        </td>
                    </tr>
                </div>
                <div class="table_content">
                @foreach($attendanceData as $data)
                    <tr class="table_records_item">
                        <td class="records_item-name">
                            <div class="result-name">
                                {{ $data->user->name }}
                            </div>
                        </td>
                        <td class="records_item-start">
                            <div class="result-start">
                                {{ $data->start_time }}
                            </div>
                        </td>
                        <td class="records_item-end">
                            <div class="result-end">
                                {{ $data->end_time }}
                            </div>
                        </td>
                        <td class="records_item-break">
                            <div class="result-break">
                                {{ $data->break_time }}
                            </div>
                        </td>
                        <td class="records_item-work">
                            <div class="result-work">
                                {{ $data->work_time }}
                            </div>
                        </td>
                    </tr>
                @endforeach
                </div>
            </table>
            {{ $attendanceData->links('vendor.pagination.custom') }}
        </div>
    </div>

@endsection