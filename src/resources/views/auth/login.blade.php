@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}" />
@endsection

@section('nav')
    <ul class = "header-nav">
        <li class = "header-nav__item">
            <a class ="header-nav__link--register" href="/register">register</a>
        </li>
    </ul>
@endsection

@section('content')
