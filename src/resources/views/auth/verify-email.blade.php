@extends('layouts.app')

@push('css')
  <link rel="stylesheet" href="{{ asset('css/pages/auth/verify-email.css') }}">
@endpush

@section('content')
  <section class="verify-email-page">
    <section class="verify-email-card">
      <p class="verify-email-card__message">
        登録していただいたメールアドレスに認証メールを送付しました。<br>
        メール認証を完了してください。
      </p>

      <a class="verify-email-card__button" href="http://localhost:8025" target="_blank" rel="noopener">
        認証はこちらから
      </a>

      <form class="verify-email-card__form" action="{{ route('verification.send') }}" method="post">
        @csrf

        <button class="verify-email-card__resend-button" type="submit">
          認証メールを再送する
        </button>
      </form>
    </section>
  </section>
@endsection