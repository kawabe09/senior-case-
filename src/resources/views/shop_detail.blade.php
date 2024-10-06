@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shop_all.css')}}">
@endsection

@section('content')

<h1>{{ $shop->name }}</h1>
<p>#{{$shop->place}}#{{$shop->type}}</p>
<p>{{ $shop->detail }}</p>

@endsection