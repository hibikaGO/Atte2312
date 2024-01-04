@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsetion

@section('header')
    <div class="header_link">
        <div class="link_item">
            <a href="" class="link_home">HOME</a>
        </div>
        <div class="link_item">
            日付一覧
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

@section('contnet')
    <div class="attendance_content">
        <div class="date">
            <div class="paginate_date_preview">
                <a href="" class="date_preview_fig"></a>
            </div>
            <div class="date_title">
                <h2>0000-00-00</h2>
            </div>
            <div class="paginate_date_next">
                <a href="" class="date_next_fig"></a>
            </div>
        </div>
    </div>
    <div class="records_content">
        <table class="records_table_inner">
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
                            休憩時間
                        </div>
                    </td>
                </tr>
            </div>
            <div class="table_records">
                <!--foreach挿入-->
                <tr class="table_records-content">
                    <td class="records_content-name">
                        <div class="result-name">
                            テスト太郎
                        </div>
                    </td>
                    <td class="records_content-start">
                        <div class="result-start">
                            00:00:00
                        </div>
                    </td>
                    <td class="records_content-end">
                        <div class="result-end">
                            00:00:00
                        </div>
                    </td>
                    <td class="records_content-break">
                        <div class="result-break">
                            00:00:00
                        </div>
                    </td>
                    <td class="records_content-work">
                        <div class="result-work">
                            00:00:00
                        </div>
                    </td>
                </tr>
                <!--endforeach-->
            </div>
        </table>
        
    </div>

@endsection