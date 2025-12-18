@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/contacts.css') }}" />
@endsection

@section('content')
<div class="contact-form">
    <div class="contact-form__title">
        <h2 class="form__title">Contact
    </div>
    <div class="contact-form__content">
        <form class="contact-form__inner" action="/confirm" method="post">
            @csrf
            <div class="contact-form__group">
                <div class="contact-form__item-wrapper">
                    <p class="contact-form__item">お名前</p>
                    <span class="form-alert">※</span>
                </div>
                <div class="contact-form__name-wrapper">
                    <input class="contact-form__name--input" type="text" name="last_name" placeholder="例：山田" value="{{old('last_name')}}">
                    <input class="contact-form__name--input" type="text" name="first_name" placeholder="例：太郎" value="{{old('first_name')}}">
                </div>
            </div>
            <div class="error">
                @if($errors->has('name'))
                <p class="error-messages">{{$errors->first('name')}}</p>
                @endif
                @error('last_name')
                <p class="error-messages">{{$message}}</p>
                @enderror
                @error('first_name')
                <p class="error-messages">{{$message}}</p>
                @enderror
            </div>
            <div class="contact-form__group">
                <div class="contact-form__item-wrapper">
                    <p class="contact-form__item">性別</p>
                    <span class="form-alert">※</span>
                </div>
                <div class="contact-form__gender-wrapper">
                    <input class="contact-form__gender--input" type="radio" name="gender" value="1" {{old('gender')=='1' ? 'checked' : ''}}>男性
                    <input class="contact-form__gender--input" type="radio" name="gender" value="2" {{old('gender')=='2' ? 'checked' : ''}}>女性
                    <input class="contact-form__gender--input" type="radio" name="gender" value="3" {{old('gender')=='3' ? 'checked' : ''}}>その他
                </div>
            </div>
            <div class="error">
                @error('gender')
                <p class="error-messages">{{$message}}</p>
                @enderror
            </div>
            <div class="contact-form__group">
                <div class="contact-form__item-wrapper">
                    <p class="contact-form__item">メールアドレス</p>
                    <span class="form-alert">※</span>
                </div>
                <div class="contact-form__email-wrapper">
                    <input class="contact-form__email--input" type="email" name="email" placeholder="例:test@example.com" value="{{old('email')}}">
                </div>
            </div>
            <div class="error">
                @error('email')
                <p class="error-messages">{{$message}}</p>
                @enderror
            </div>
            <div class="contact-form__group">
                <div class="contact-form__item-wrapper">
                    <p class="contact-form__item">電話番号</p>
                    <span class="form-alert">※</span>
                </div>
                <div class="contact-form__tel-wrapper">
                    <input class="contact-form__tel--input" type="text" name="tel1" placeholder="090" value="{{old('tel1')}}">-
                    <input class="contact-form__tel--input" type="text" name="tel2" placeholder="1234" value="{{old('tel2')}}">-
                    <input class="contact-form__tel--input" type="text" name="tel3" placeholder="5678" value="{{old('tel3')}}">
                </div>
            </div>
            <div class="error">
                @error('tel1')
                <p class="error-messages">{{$message}}</p>
                @enderror
                @error('tel2')
                <p class="error-messages">{{$message}}</p>
                @enderror
                @error('tel3')
                <p class="error-messages">{{$message}}</p>
                @enderror
            </div>
            <div class="contact-form__group">
                <div class="contact-form__item-wrapper">
                    <p class="contact-form__item">住所</p>
                    <span class="form-alert">※</span>
                </div>
                <div class="contact-form__address-wrapper">
                    <input class="contact-form__address--input" type="text" name="address" placeholder="例:東京都渋谷区千駄ヶ谷1-2-3" value="{{old('address')}}">
                </div>
            </div>
            <div class="error">
                @error('address')
                <p class="error-messages">{{$message}}</p>
                @enderror
            </div>
            <div class="contact-form__group">
                <div class="contact-form__item-wrapper">
                    <p class="contact-form__item">建物名</p>
                    <span class="form-alert"></span>
                </div>
                <div class="contact-form__building-wrapper">
                    <input class="contact-form__building--input" type="text" name="building" placeholder="例:千駄ヶ谷マンション101" value="{{old('building')}}">
                </div>
            </div>
            <div class="contact-form__group">
                <div class="contact-form__item-wrapper">
                    <p class="contact-form__item">お問い合わせの種類</p>
                    <span class="form-alert">※</span>
                </div>
                <div class="contact-form__category-wrapper">
                    <select class="contact-form__category--select" id="category_id" name="category_id">
                        <option value="">選択してください</option>
                        @foreach($categories as $category)
                        <option value="{{$category->id}}" {{old('category_id')==$category->id ? 'selected' : ''}}>{{$category->content}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="error">
                @error('category_id')
                <p class="error-messages">{{$message}}</p>
                @enderror
            </div>
            <div class="contact-form__group">
                <div class="contact-form__item-wrapper">
                    <p class="contact-form__item">お問い合わせの内容</p>
                    <span class="form-alert">※</span>
                </div>
                <div class="contact-form__detail-wrapper">
                    <textarea class="contact-form__detail--textarea" name="detail" placeholder="お問い合わせ内容をご記載ください" rows="5">{{old('detail')}}</textarea>
                </div>
            </div>
            <div class="error">
                @error('detail')
                <p class="error-messages">{{$message}}</p>
                @enderror
            </div>
            <div class="contact-form__button">
                <button class="contact-form__button--submit" type="submit">確認画面</button>
            </div>
        </form>
    </div>
</div>
@endsection