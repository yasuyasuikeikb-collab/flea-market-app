@extends('layouts.app')

@push('css')
  <link rel="stylesheet" href="{{ asset('css/pages/profile/edit.css') }}">
@endpush

@section('content')
  <section class="profile-edit">
    <h2 class="profile-edit__title">プロフィール設定</h2>

    {{-- プロフィール編集フォーム --}}
    <form class="profile-form" action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
      @csrf

      <section class="profile-form__image-section">
        <figure class="profile-form__avatar-frame">
          @if($user->profile_image)
            <img
              class="profile-form__avatar"
              src="{{ asset('storage/' . $user->profile_image) }}"
              alt="{{ $user->name }}"
            >
          @else
            <span class="profile-form__avatar-placeholder"></span>
          @endif
        </figure>

        <label class="profile-form__image-label" for="profile_image">画像を選択する</label>
        <input
          id="profile_image"
          class="profile-form__image-input"
          type="file"
          name="profile_image"
          accept="image/png,image/jpeg"
        >

        @error('profile_image')
          <p class="profile-form__error">{{ $message }}</p>
        @enderror
      </section>

      <section class="profile-form__group">
        <label class="profile-form__label" for="name">ユーザー名</label>
        <input
          id="name"
          class="profile-form__input"
          type="text"
          name="name"
          value="{{ old('name', $user->name) }}"
        >
        @error('name')
          <p class="profile-form__error">{{ $message }}</p>
        @enderror
      </section>

      <section class="profile-form__group">
        <label class="profile-form__label" for="postal_code">郵便番号</label>
        <input
          id="postal_code"
          class="profile-form__input"
          type="text"
          name="postal_code"
          value="{{ old('postal_code', $user->postal_code) }}"
        >
        @error('postal_code')
          <p class="profile-form__error">{{ $message }}</p>
        @enderror
      </section>

      <section class="profile-form__group">
        <label class="profile-form__label" for="address">住所</label>
        <input
          id="address"
          class="profile-form__input"
          type="text"
          name="address"
          value="{{ old('address', $user->address) }}"
        >
        @error('address')
          <p class="profile-form__error">{{ $message }}</p>
        @enderror
      </section>

      <section class="profile-form__group">
        <label class="profile-form__label" for="building">建物名</label>
        <input
          id="building"
          class="profile-form__input"
          type="text"
          name="building"
          value="{{ old('building', $user->building) }}"
        >
      </section>

      <button class="profile-form__button" type="submit">更新する</button>
    </form>
  </section>
@endsection