@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}" />
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
<div class="message">
    @if(session('message'))
    <p class="message__text">{{ session('message') }}</p>
    @endif
    @if ($exports->first()->status === 'pending')
    <p class="message__text">生成中…</p>
    @elseif ($exports->first()->status === 'completed')
        <a href="{{ route('exports.download', $exports->first()->id) }}">
            ダウンロード
        </a>
    @endif
</div>
<div class="admin-page">
    <div class="admin-page__title">
        <h2 class="form__title">Admin</h2>
    </div>
    <div class="search-form__group">
        <form class="search-form" action="/search" method="get">
            @csrf
            <div class="search-form__inner">
                <input class="search-form__input" type="text" name="keyword" id="keyword" placeholder="お名前やメールアドレスを入力してください">
                <select class="search-form__select" name="gender" id="gender">
                    <option class="search-form__select" value="">性別</option>
                    <option class="search-form__select" value="1">男性</option>
                    <option class="search-form__select" value="2">女性</option>
                    <option class="search-form__select" value="3">その他</option>
                </select>
                <select class="search-form__select" name="category_id" id="category_id">
                    <option class="search-form__select" value="">お問い合わせの種類</option>
                    @foreach($categories as $category)
                    <option class="search-form__select" value="{{$category->id}}">{{$category->content}}</option>
                    @endforeach
                </select>
                <input class="search-form__select" type="date" name="created_at" id="created_at">
            </div>
            <div class="search-form__button">
                <button class="search__button--submit" type="submit">検索</button>
                <a class="reset__button" href="/admin">リセット</a>
            </div>
        </form>
    </div>
    <div class="optional__group">
        <div class="csv-button">
            <a class="csv-button__link" href="{{route('admin.csv' ,request()->query()) }}">エクスポート</a>
        </div>
        <div class="pagination">
            @if($contacts->onFirstPage())
            <div class="previous">&lt;</div>
            @else
            <div class="previous">
                <a class="pagination-link" href="{{$contacts->previousPageUrl()}}" rel="prev">&lt;</a>
            </div>
            @endif
            @for($page=1; $page<=$contacts->lastPage();$page++)
                @if($contacts->currentPage()==$page)
                <div class="current">{{$page}}</div>
                @else
                <div class="other">
                    <a class="pagination-link" href="{{$contacts->url($page)}}&{{ http_build_query(request()->except('page')) }}">{{$page}}</a>
                </div>
                @endif
                @endfor
                @if($contacts->hasMorePages())
                <div class="last">
                    <a class="pagination-link" href="{{$contacts->nextPageUrl()}}&{{ http_build_query(request()->except('page')) }}" rel="next">&gt;</a>
                </div>
                @else
                <div class="last">&gt;</div>
                @endif
        </div>
    </div>
    <div class=" admin-page__content">
        <table class="admin-table">
            <thead>
                <tr class="admin-table__inner">
                    <th class="admin-table__title">お名前</th>
                    <th class="admin-table__title">性別</th>
                    <th class="admin-table__title">メールアドレス</th>
                    <th class="admin-table__title">お問い合わせの種類</th>
                    <th class="admin-table__title"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($contacts as $contact)
                <tr class="admin-table__row">
                    <td class=" admin-table__item">{{$contact->last_name}}{{$contact->first_name}}</td>
                    <td class=" admin-table__item">{{$contact->gender_text}}</td>
                    <td class=" admin-table__item">{{$contact->email}}</td>
                    <td class=" admin-table__item">{{$contact->category->content}}</td>
                    <td>
                        @livewire('modal', ['contactId' => $contact->id])
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection