@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}" />
@endsection

@section('nav')
<ul class="header-nav--inner">
    <li class="header-nav__item">
        <a class="header-nav__link--login" href="/login">login</a>
    </li>
</ul>
@endsection

@section('content')
<div class="register-form">
    <div class="register-form__title">
        <h2 class="form__title">Register</h2>
    </div>
    <div class="register-form__content">
        <form class="register-form__inner" action="/register" method="post">
            @csrf
            <div class="register-form__group">
                <div class="register-form__label">
                    <p class="register-form__item">お名前</p>
                </div>
                <input class="register-form__name--input" type="text" name="name" placeholder="例：山田　太郎" value="{{old('name')}}">
            </div>
            <div class="error">
                @error('name')
                <p class="error-messages">{{$message}}</p>
                @enderror
            </div>
            <div class="register-form__group">
                <div class="register-form__label">
                    <p class="register-form__item">メールアドレス</p>
                </div>
                <input class="register-form__email--input" type="text" name="email" placeholder="例：test@example.com" value="{{old('email')}}">
            </div>
            <div class="error">
                @error('email')
                <p class="error-messages">{{$message}}</p>
                @enderror
            </div>
            <div class="register-form__group">
                <div class="register-form__label">
                    <p class="register-form__item">パスワード</p>
                </div>
                    <input class="register-form__password--input" type="text" name="password" placeholder="例：password">
                </div>
                <div class="error">
                    @error('password')
                    <p class="error-messages">{{$message}}</p>
                    @enderror
                </div>
                <div class="register-form__group">
                <div class="register-form__label">
                    <p class="register-form__item">パスワード確認</p>
                </div>
                    <input class="register-form__password--input" type="text" name="password_confirmation" placeholder="例：password">
                </div>
                <div class="error">
                    @error('password_confirmation')
                    <p class="error-messages">{{$message}}</p>
                    @enderror
                </div>
                <div class="register-form__button">
                    <button class="register-form__button--submit" type="submit">登録</button>
                </div>
        </form>
    </div>
</div>
@endsection