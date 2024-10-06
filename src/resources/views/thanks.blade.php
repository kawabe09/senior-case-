@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css')}}">
@endsection

@section('content')
<p>会員登録ありがとうございます</p>
<a href="/login">ログインする</a>
@endsection