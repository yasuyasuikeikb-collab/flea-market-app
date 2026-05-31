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
    $paymentMethod = old('payment_method');
  @endphp

  <section class="purchase-page">
    {{-- 購入フォーム --}}
    <form class="purchase-form" action="{{ route('purchase.checkout', ['item_id' => $item->id]) }}" method="post" novalidate>
      @csrf

      <section class="purchase-form__main">
        {{-- 購入商品 --}}
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

        {{-- 支払い方法 --}}
        <section class="purchase-section">
          <h3 class="purchase-section__title">支払い方法</h3>

          <section class="payment-select" data-payment-select>
            <input
              type="hidden"
              name="payment_method"
              value="{{ $paymentMethod }}"
              data-payment-input
            >

            <button
              class="payment-select__button"
              type="button"
              data-payment-button
            >
              {{ $paymentMethod ?: '選択してください' }}
            </button>

            <ul class="payment-select__list" data-payment-list>
              <li class="payment-select__item">
                <button
                  class="payment-select__option {{ $paymentMethod === 'コンビニ払い' ? 'is-selected' : '' }}"
                  type="button"
                  value="コンビニ払い"
                  data-payment-option
                >
                  <span class="payment-select__check">✓</span>
                  <span>コンビニ払い</span>
                </button>
              </li>

              <li class="payment-select__item">
                <button
                  class="payment-select__option {{ $paymentMethod === 'カード支払い' ? 'is-selected' : '' }}"
                  type="button"
                  value="カード支払い"
                  data-payment-option
                >
                  <span class="payment-select__check">✓</span>
                  <span>カード支払い</span>
                </button>
              </li>
            </ul>
          </section>

          @error('payment_method')
            <p class="purchase-section__error">{{ $message }}</p>
          @enderror
        </section>

        {{-- 配送先 --}}
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

      {{-- 購入内容 --}}
      <aside class="purchase-summary" aria-label="購入内容">
        <dl class="purchase-summary__list">
          <div class="purchase-summary__row">
            <dt class="purchase-summary__term">商品代金</dt>
            <dd class="purchase-summary__description">¥{{ number_format($item->price) }}</dd>
          </div>

          <div class="purchase-summary__row">
            <dt class="purchase-summary__term">支払い方法</dt>
            <dd class="purchase-summary__description" data-payment-summary>
              {{ $paymentMethod ?: '選択してください' }}
            </dd>
          </div>
        </dl>

        <button class="purchase-summary__button" type="submit">購入する</button>
      </aside>
    </form>
  </section>

  <script>
    const paymentSelect = document.querySelector('[data-payment-select]');
    const paymentButton = document.querySelector('[data-payment-button]');
    const paymentInput = document.querySelector('[data-payment-input]');
    const paymentList = document.querySelector('[data-payment-list]');
    const paymentOptions = document.querySelectorAll('[data-payment-option]');
    const paymentSummary = document.querySelector('[data-payment-summary]');

    paymentButton.addEventListener('click', () => {
      paymentList.classList.toggle('is-open');
      paymentButton.classList.toggle('is-open');
    });

    paymentOptions.forEach((option) => {
      option.addEventListener('click', () => {
        paymentInput.value = option.value;
        paymentButton.textContent = option.value;
        paymentSummary.textContent = option.value;

        paymentOptions.forEach((paymentOption) => {
          paymentOption.classList.remove('is-selected');
        });

        option.classList.add('is-selected');
        paymentList.classList.remove('is-open');
        paymentButton.classList.remove('is-open');
      });
    });

    document.addEventListener('click', (event) => {
      if (!paymentSelect.contains(event.target)) {
        paymentList.classList.remove('is-open');
        paymentButton.classList.remove('is-open');
      }
    });
  </script>
@endsection