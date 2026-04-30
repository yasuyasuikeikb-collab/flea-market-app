@extends('layouts.app')

@push('css')
  <link rel="stylesheet" href="{{ asset('css/pages/auth/register.css') }}">
@endpush

@section('content')
  <section class="auth-page">
    <h2 class="auth-page__title">会員登録</h2>

    {{-- 会員登録フォーム --}}
    <form class="auth-form" action="{{ route('register') }}" method="post">
      @csrf

      <section class="auth-form__group">
        <label class="auth-form__label" for="name">ユーザー名</label>
        <input
          id="name"
          class="auth-form__input"
          type="text"
          name="name"
          value="{{ old('name') }}"
        >
        @error('name')
          <p class="auth-form__error">{{ $message }}</p>
        @enderror
      </section>

      <section class="auth-form__group">
        <label class="auth-form__label" for="email">メールアドレス</label>
        <input
          id="email"
          class="auth-form__input"
          type="email"
          name="email"
          value="{{ old('email') }}"
        >
        @error('email')
          <p class="auth-form__error">{{ $message }}</p>
        @enderror
      </section>

      <section class="auth-form__group">
        <label class="auth-form__label" for="password">パスワード</label>
        <input
          id="password"
          class="auth-form__input"
          type="password"
          name="password"
        >
        @error('password')
          <p class="auth-form__error">{{ $message }}</p>
        @enderror
      </section>

      <section class="auth-form__group">
        <label class="auth-form__label" for="password_confirmation">確認用パスワード</label>
        <input
          id="password_confirmation"
          class="auth-form__input"
          type="password"
          name="password_confirmation"
        >
        @error('password_confirmation')
          <p class="auth-form__error">{{ $message }}</p>
        @enderror
      </section>

      <button class="auth-form__button" type="submit">登録する</button>

      <p class="auth-form__link">
        <a href="{{ route('login') }}">ログインはこちら</a>
      </p>
    </form>
  </section>
@endsection