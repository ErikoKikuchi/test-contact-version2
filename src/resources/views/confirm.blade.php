@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/confirm.css') }}" />
@endsection

@section('content')
<div class="confirm-form">
    <div class="confirm-form__title">
        <h2 class="form__title">Confirm
    </div>
    <div class="confirm-form__content">
        <form class="confirm-form__inner" action="{{ route('store') }}" method="post">
            @csrf
            <div class="confirm-form__group">
                <p class="confirm-form__item">お名前</p>
                <div class="confirm-form__name-wrapper">
                    <input class="confirm-form__name--input" type="text" name="last_name" value="{{$contact->last_name}}" readonly>
                    <input class="confirm-form__name--input" type="text" name="first_name" value="{{$contact->first_name}}" readonly>
                </div>
            </div>
            <div class="confirm-form__group">
                <p class="confirm-form__item">性別</p>
                <div class="confirm-form__gender-wrapper">
                    <input class="confirm-form__gender--input" type="hidden" name="gender" value="{{$contact->gender}}">
                    <p class="confirm-form__gender--display">{{$contact->gender_text}}</p>
                </div>
            </div>
            <div class="confirm-form__group">
                <p class="confirm-form__item">メールアドレス</p>
                <div class="confirm-form__email-wrapper">
                    <input class="confirm-form__email--input" type="email" name="email" value="{{$contact->email}}" readonly>
                </div>
            </div>
            <div class="confirm-form__group">
                <p class="confirm-form__item">電話番号</p>
                <div class="confirm-form__tel-wrapper">
                    <input class="confirm-form__tel--input" type="text" name="tel1" value="{{$contact->tel1}}" readonly>
                    <input class="confirm-form__tel--input" type="text" name="tel2" value="{{$contact->tel2}}" readonly>
                    <input class="confirm-form__tel--input" type="text" name="tel3" value="{{$contact->tel3}}" readonly>
                </div>
            </div>
            <div class="confirm-form__group">
                <p class="confirm-form__item">住所</p>
                <div class="confirm-form__address-wrapper">
                    <input class="confirm-form__address--input" type="text" name="address" value="{{$contact->address}}" readonly>
                </div>
            </div>
            <div class="confirm-form__group">
                <p class="confirm-form__item">建物名</p>
                <div class="confirm-form__building-wrapper">
                    <input class="confirm-form__building--input" type="text" name="building" value="{{$contact->building}}" readonly>
                </div>
            </div>
            <div class="confirm-form__group">
                <p class="confirm-form__item">お問い合わせの種類</p>
                <div class="confirm-form__category-wrapper">
                    <input class="confirm-form__category--input" type="hidden" name="category_id" value="{{$contact->category_id}}">
                    <p class="confirm-form__category_id--display">{{$contact->category->content}}</p>
                </div>
            </div>
            <div class="confirm-form__group">
                <p class="confirm-form__item">お問い合わせの内容</p>
                <div class="confirm-form__detail-wrapper">
                    <input class="confirm-form__detail--input" name="detail" value="{{$contact->detail}}" readonly>
                </div>
            </div>
            <div class="confirm-form__button">
                <button class="confirm-form__button--submit" type="submit" name="action" value="save">送信</button>
                <button class="back-form__button" type="submit" name="action" value="back">修正</button>
            </div>
        </form>
    </div>
</div>
@endsection