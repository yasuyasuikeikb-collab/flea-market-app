@extends('layouts.app')

@push('css')
  <link rel="stylesheet" href="{{ asset('css/pages/purchase/create.css') }}">
@endpush

@section('content')
  @php
    $address = session('purchase_address_' . $item->id);
    $postalCode = old('postal_code', $address['postal_code'] ?? $user->postal_code);
    $shippingAddress = old('address', $address['address'] ?? $user->address);
    $building = old('building', $address['building'] ?? $user->building);
  @endphp

  <section class="purchase-page">
    {{-- 購入フォーム --}}
    <form class="purchase-form" action="{{ route('purchase.store', ['item_id' => $item->id]) }}" method="post">
      @csrf

      <section class="purchase-form__main">
        <article class="purchase-item">
          <figure class="purchase-item__image-frame">
            <img
              class="purchase-item__image"
              src="{{ filter_var($item->image_path, FILTER_VALIDATE_URL) ? $item->image_path : asset('storage/' . $item->image_path) }}"
              alt="{{ $item->name }}"
            >
          </figure>

          <section class="purchase-item__body">
            <h2 class="purchase-item__name">{{ $item->name }}</h2>
            <p class="purchase-item__price">¥{{ number_format($item->price) }}</p>
          </section>
        </article>

        <section class="purchase-section">
          <h3 class="purchase-section__title">支払い方法</h3>

          <select class="purchase-section__select" name="payment_method">
            <option value="">選択してください</option>
            <option value="コンビニ払い" {{ old('payment_method') === 'コンビニ払い' ? 'selected' : '' }}>コンビニ払い</option>
            <option value="カード支払い" {{ old('payment_method') === 'カード支払い' ? 'selected' : '' }}>カード支払い</option>
          </select>

          @error('payment_method')
            <p class="purchase-section__error">{{ $message }}</p>
          @enderror
        </section>

        <section class="purchase-section">
          <header class="purchase-section__header">
            <h3 class="purchase-section__title">配送先</h3>
            <a class="purchase-section__link" href="{{ route('purchase.address.edit', ['item_id' => $item->id]) }}">変更する</a>
          </header>

          <p class="purchase-section__address">〒 {{ $postalCode }}</p>
          <p class="purchase-section__address">{{ $shippingAddress }} {{ $building }}</p>

          <input type="hidden" name="postal_code" value="{{ $postalCode }}">
          <input type="hidden" name="address" value="{{ $shippingAddress }}">
          <input type="hidden" name="building" value="{{ $building }}">

          @error('postal_code')
            <p class="purchase-section__error">{{ $message }}</p>
          @enderror

          @error('address')
            <p class="purchase-section__error">{{ $message }}</p>
          @enderror
        </section>
      </section>

      <aside class="purchase-summary" aria-label="購入内容">
        <dl class="purchase-summary__list">
          <section class="purchase-summary__row">
            <dt class="purchase-summary__term">商品代金</dt>
            <dd class="purchase-summary__description">¥{{ number_format($item->price) }}</dd>
          </section>

          <section class="purchase-summary__row">
            <dt class="purchase-summary__term">支払い方法</dt>
            <dd class="purchase-summary__description">{{ old('payment_method', '選択してください') }}</dd>
          </section>
        </dl>

        <button class="purchase-summary__button" type="submit">購入する</button>
      </aside>
    </form>
  </section>
@endsection