@extends('layouts.common')
<style>
    th {
        background-color: #289ADC;
        color: white;
        padding: 5px 40px;
    }

    tr:nth-child(odd) td {
        background-color: #FFFFFF;
    }

    td {
        padding: 25px 40px;
        background-color: #EEEEEE;
        text-align: center;
    }

    svg.w-5.h-5 {
        /*paginateメソッドの矢印の大きさ調整のために追加*/
        width: 30px;
        height: 30px;
    }
</style>
@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css')}}">
@endsection

@section('content')
<table>
{{ $timestamps->appends(['page' => $timestamps->currentPage()])->links() }}
<tr>
    <td>名前</td>
    <td>勤務開始</td>
    <td>勤務終了</td>
    <td>休憩時間</td>
    <td>勤務時間</td>
</tr>
<br>
@foreach ($timestamps as $timestamp)
<tr>
    <td>{{$timestamp->user_id}}</td>
    <td>{{$timestamp->punchIn}}</td>
    <td>{{$timestamp->punchOut}}</td>
    <td>{{$timestamp->rest_time}}</td>
    <td>{{$timestamp->work_time}}</td>
</tr>
@endforeach
</table>

<div class="">
    <form action="/" class="">
        <input type="submit" value="ホーム">
    </form>
</div>
<div class="">
    <form action="/data" class="">
        <input type="submit" value="日付一覧">
    </form>
</div>
@endsection