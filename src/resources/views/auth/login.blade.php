@extends('layouts.app')

@push('css')
  <link rel="stylesheet" href="{{ asset('css/pages/auth/login.css') }}">
@endpush

@section('content')
  <section class="auth-page">
    <h2 class="auth-page__title">ログイン</h2>

    {{-- ログインフォーム --}}
    <form class="auth-form" action="{{ route('login') }}" method="post">
      @csrf

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

      <button class="auth-form__button" type="submit">ログインする</button>

      <p class="auth-form__link">
        <a href="{{ route('register') }}">会員登録はこちら</a>
      </p>
    </form>
  </section>
@endsection