@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}" />
@endsection

@section('nav')
    <ul class = "header-nav--inner">
        <li class = "header-nav__item">
            <a class ="header-nav__link--login" href="/login">login</a>
        </li>
    </ul>
@endsection

@section('content')
