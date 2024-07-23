@extends('layouts.common')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css')}}">
@endsection

@section('content')
<h2>お疲れ様です</h2>
<div class="">
    <p class="">{{Auth::user()->name}}</p>
</div>
<div class="">
    <form action="/start" class="">
        <input type="submit" value="勤務開始">
    </form>
    <form action="/end" class="">
        <input type="submit" value="勤務終了">
    </form>
    <form action="/rest" class="">
        <input type="submit" value="休憩開始">
    </form>
    <form action="rest_end" class="">
        <input type="submit" value="休憩終了">
    </form>
</div>
<form action="/logout" class="" method="post">
    @csrf
    <button>ログアウト</button>
</form>
@endsection