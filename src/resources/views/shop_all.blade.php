@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shop_all.css')}}">
@endsection

@section('content')

@foreach ($shops as $shop)
<div>
    <h2>{{$shop->name}}</h2>
    <p>#{{$shop->place}}#{{$shop->type}}</p>
    <a href="">詳しくみる</a>
</div>
@endforeach

<form action="/logout" method="post">
    @csrf
<button class="header-nav__button">ログアウト</button>
</form>
@endsection