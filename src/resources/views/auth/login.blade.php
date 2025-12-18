@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}" />
@endsection

@section('nav')
<ul class="header-nav">
    <li class="header-nav__item">
        <a class="header-nav__link--register" href="/register">register</a>
    </li>
</ul>
@endsection

@section('content')
<div class="login-form">
    <div class="login-form__title">
        <h2 class="form__title">Login</h2>
    </div>
    <div class="login-form__content">
        <form class="login-form__inner" action="/login" method="post">
            @csrf
            <div class="login-form__group">
                <div class="login-form__label">
                    <p class="login-form__item">メールアドレス</p>
                </div>
                <input class="login-form__email--input" type="text" name="email" placeholder="例：test@example.com" value="{{old('email')}}">
            </div>
            <div class="error">
                @error('email')
                <p class="error-messages">{{$message}}</p>
                @enderror
            </div>
            <div class="login-form__group">
                <div class="login-form__label">
                    <p class="login-form__item">パスワード</p>
                </div>
                <input class="login-form__password--input" type="text" name="password" placeholder="例：password">
            </div>
            <div class="error">
                @error('password')
                <p class="error-messages">{{$message}}</p>
                @enderror
            </div>
            <div class="login-form__button">
                <button class="login-form__button--submit" type="submit">ログイン</button>
            </div>
        </form>
    </div>
</div>
@endsection