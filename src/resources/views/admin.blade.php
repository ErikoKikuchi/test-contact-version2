@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/confirm.css') }}" />
@endsection

@section('nav')
<form class="logout" action="/logout" method="post">
    @csrf
    <ul class="header-nav--inner">
        <li class="header-nav__item">
            <button class="header-nav__link--logout" type="submit">logout</button>
        </li>
    </ul>
</form>
@endsection

@section('content')
<div class="admin-page">
    <div class="admin-page__title">
        <h2 class="form__title">Admin</h2>
    </div>
    <div class="search-form__group">
        //検索機能
    </div>
    <div class="optional__group">
        //CSV
        //pagination
    </div>
    <div class="admin-page__content">
        <table class="admin-table">
            <tr class="admin-table__inner">
                <th class="admin-table__title">お名前</th>
                <th class="admin-table__title">性別</th>
                <th class="admin-table__title">メールアドレス</th>
                <th class="admin-table__title">お問い合わせの種類</th>
                <th class="admin-table__title"></th>
            </tr>
            <tr>
                @foreach($contacts as $contact)
                <td></td>
                @endforeach
            </tr>
        </table>
    </div>
</div>

@endsection