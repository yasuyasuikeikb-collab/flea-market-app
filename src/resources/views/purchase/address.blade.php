@extends('layouts.app')

@push('css')
  <link rel="stylesheet" href="{{ asset('css/pages/purchase/address.css') }}">
@endpush

@section('content')
  <section class="address-page">
    <h2 class="address-page__title">住所の変更</h2>

    {{-- 送付先住所変更フォーム --}}
    <form class="address-form" action="{{ route('purchase.address.update', ['item_id' => $item->id]) }}" method="post">
      @csrf

      <section class="address-form__group">
        <label class="address-form__label" for="postal_code">郵便番号</label>
        <input
          id="postal_code"
          class="address-form__input"
          type="text"
          name="postal_code"
          value="{{ old('postal_code', $user->postal_code) }}"
        >

        @error('postal_code')
          <p class="address-form__error">{{ $message }}</p>
        @enderror
      </section>

      <section class="address-form__group">
        <label class="address-form__label" for="address">住所</label>
        <input
          id="address"
          class="address-form__input"
          type="text"
          name="address"
          value="{{ old('address', $user->address) }}"
        >

        @error('address')
          <p class="address-form__error">{{ $message }}</p>
        @enderror
      </section>

      <section class="address-form__group">
        <label class="address-form__label" for="building">建物名</label>
        <input
          id="building"
          class="address-form__input"
          type="text"
          name="building"
          value="{{ old('building', $user->building) }}"
        >
      </section>

      <button class="address-form__button" type="submit">更新する</button>
    </form>
  </section>
@endsection