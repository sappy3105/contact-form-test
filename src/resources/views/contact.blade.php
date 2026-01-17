@extends('layouts.app_contact')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/contact.css') }}">
@endsection

@section('content')
    <div class="contact-form__content">
        <div class="contact-form__heading">
            <h2>Contact</h2>
        </div>
        <form class="form" action="/confirm" method="post" novalidate>{{-- ブラウザのエラーを非表示 --}}
            @csrf
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">お名前</span>
                    <span class="form__label--required">※</span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--name">
                        <div class="form__input-inner">
                            <input type="text" name="last_name" placeholder="例　山田" value="{{ old('last_name') }}" />
                            <div class="form__error">
                                @error('last_name')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="form__input-inner">
                            <input type="text" name="first_name" placeholder="例　太郎" value="{{ old('first_name') }}" />
                            <div class="form__error">
                                @error('first_name')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">性別</span>
                    <span class="form__label--required">※</span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--gender">
                        <label class="gender-item">
                            <input type="radio" name="gender" value="1" class="gender-input"
                                {{ old('gender') == '1' ? 'checked' : '' }} />
                            <span class="gender-text">男性</span>
                        </label>
                        <label class="gender-item">
                            <input type="radio" name="gender" value="2" class="gender-input"
                                {{ old('gender') == '2' ? 'checked' : '' }} />
                            <span class="gender-text">女性</span>
                        </label>
                        <label class="gender-item">
                            <input type="radio" name="gender" value="3" class="gender-input"
                                {{ old('gender') == '3' ? 'checked' : '' }} />
                            <span class="gender-text">その他</span>
                        </label>
                    </div>
                    <div class="form__error">
                        @error('gender')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">メールアドレス</span>
                    <span class="form__label--required">※</span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--email">
                        <input type="text" name="email" placeholder="例　test@example.com" value="{{ old('email') }}" />
                        {{-- ブラウザのエラーを外すためにtype="text"にした --}}
                    </div>
                    <div class="form__error">
                        @error('email')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">電話番号</span>
                    <span class="form__label--required">※</span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--tel">
                        <input type="tel" name="tel1" placeholder="090" value="{{ old('tel1') }}" />
                        <span>-</span>
                        <input type="tel" name="tel2" placeholder="1234" value="{{ old('tel2') }}" />
                        <span>-</span>
                        <input type="tel" name="tel3" placeholder="5678" value="{{ old('tel3') }}" />
                    </div>
                    <div class="form__error">
                        @error('tel_all')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">住所</span>
                    <span class="form__label--required">※</span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--address">
                        <input type="text" name="address" placeholder="例　東京都渋谷区千駄ヶ谷1-2-3"
                            value="{{ old('address') }}" />
                    </div>
                    <div class="form__error">
                        @error('address')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">建物名</span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--building">
                        <input type="text" name="building" placeholder="例　千駄ヶ谷マンション101" value="{{ old('building') }}" />
                    </div>
                    <div class="form__error"></div>
                </div>
            </div>
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">お問い合わせの種類</span>
                    <span class="form__label--required">※</span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--category">
                        <select class="category-select" name="category_id" required>
                            <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>選択してください
                            </option>
                            @foreach ($categories as $category)
                                <option value="{{ $category['id'] }}"
                                    {{ old('category_id') == $category['id'] ? 'selected' : '' }}>
                                    {{ $category['content'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form__error">
                        @error('category_id')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">お問い合わせ内容</span>
                    <span class="form__label--required">※</span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--detail">
                        <textarea name="detail" placeholder="お問い合わせ内容をご記載ください">{{ old('detail') }}</textarea>
                    </div>
                    <div class="form__error">
                        @error('detail')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form__button">
                <button class="form__button-submit" type="submit">確認画面</button>
            </div>
        </form>
    </div>
@endsection
