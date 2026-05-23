@extends('layouts.app')

@push('css')
  <link rel="stylesheet" href="{{ asset('css/pages/sell/create.css') }}">
@endpush

@section('content')
  @php
    $condition = old('condition');
  @endphp

  <section class="sell-page">
    <h2 class="sell-page__title">商品の出品</h2>

    {{-- 商品出品フォーム --}}
    <form class="sell-form" action="{{ route('sell.store') }}" method="post" enctype="multipart/form-data" novalidate>
      @csrf

      <section class="sell-form__section">
        <h3 class="sell-form__heading">商品画像</h3>

        <label class="sell-form__image-label" for="image">画像を選択する</label>
        <input
          id="image"
          class="sell-form__image-input"
          type="file"
          name="image"
          accept="image/png,image/jpeg"
        >

        @error('image')
          <p class="sell-form__error">{{ $message }}</p>
        @enderror
      </section>

      <section class="sell-form__section">
        <h3 class="sell-form__section-title">商品の詳細</h3>

        <fieldset class="sell-form__fieldset">
          <legend class="sell-form__heading">カテゴリー</legend>

          <ul class="category-list">
            @foreach($categories as $category)
              <li class="category-list__item">
                <input
                  id="category-{{ $category->id }}"
                  class="category-list__input"
                  type="checkbox"
                  name="categories[]"
                  value="{{ $category->id }}"
                  {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}
                >
                <label class="category-list__label" for="category-{{ $category->id }}">
                  {{ $category->name }}
                </label>
              </li>
            @endforeach
          </ul>

          @error('categories')
            <p class="sell-form__error">{{ $message }}</p>
          @enderror
        </fieldset>

        <section class="sell-form__group">
          <label class="sell-form__heading" for="condition">商品の状態</label>

          {{-- 商品状態のカスタムセレクト --}}
          <section class="condition-select" data-condition-select>
            <input
              id="condition"
              type="hidden"
              name="condition"
              value="{{ $condition }}"
              data-condition-input
            >

            <button
              class="condition-select__button"
              type="button"
              data-condition-button
            >
              {{ $condition ?: '選択してください' }}
            </button>

            <ul class="condition-select__list" data-condition-list>
              <li class="condition-select__item">
                <button
                  class="condition-select__option {{ $condition === '良好' ? 'is-selected' : '' }}"
                  type="button"
                  value="良好"
                  data-condition-option
                >
                  <span class="condition-select__check">✓</span>
                  <span>良好</span>
                </button>
              </li>

              <li class="condition-select__item">
                <button
                  class="condition-select__option {{ $condition === '目立った傷や汚れなし' ? 'is-selected' : '' }}"
                  type="button"
                  value="目立った傷や汚れなし"
                  data-condition-option
                >
                  <span class="condition-select__check">✓</span>
                  <span>目立った傷や汚れなし</span>
                </button>
              </li>

              <li class="condition-select__item">
                <button
                  class="condition-select__option {{ $condition === 'やや傷や汚れあり' ? 'is-selected' : '' }}"
                  type="button"
                  value="やや傷や汚れあり"
                  data-condition-option
                >
                  <span class="condition-select__check">✓</span>
                  <span>やや傷や汚れあり</span>
                </button>
              </li>

              <li class="condition-select__item">
                <button
                  class="condition-select__option {{ $condition === '状態が悪い' ? 'is-selected' : '' }}"
                  type="button"
                  value="状態が悪い"
                  data-condition-option
                >
                  <span class="condition-select__check">✓</span>
                  <span>状態が悪い</span>
                </button>
              </li>
            </ul>
          </section>

          @error('condition')
            <p class="sell-form__error">{{ $message }}</p>
          @enderror
        </section>
      </section>

      <section class="sell-form__section">
        <h3 class="sell-form__section-title">商品名と説明</h3>

        <section class="sell-form__group">
          <label class="sell-form__heading" for="name">商品名</label>
          <input
            id="name"
            class="sell-form__input"
            type="text"
            name="name"
            value="{{ old('name') }}"
          >

          @error('name')
            <p class="sell-form__error">{{ $message }}</p>
          @enderror
        </section>

        <section class="sell-form__group">
          <label class="sell-form__heading" for="brand_name">ブランド名</label>
          <input
            id="brand_name"
            class="sell-form__input"
            type="text"
            name="brand_name"
            value="{{ old('brand_name') }}"
          >
        </section>

        <section class="sell-form__group">
          <label class="sell-form__heading" for="description">商品の説明</label>
          <textarea id="description" class="sell-form__textarea" name="description">{{ old('description') }}</textarea>

          @error('description')
            <p class="sell-form__error">{{ $message }}</p>
          @enderror
        </section>

        <section class="sell-form__group">
          <label class="sell-form__heading" for="price">販売価格</label>
          <input
            id="price"
            class="sell-form__input"
            type="text"
            name="price"
            value="{{ old('price') }}"
            placeholder="¥"
          >

          @error('price')
            <p class="sell-form__error">{{ $message }}</p>
          @enderror
        </section>
      </section>

      <button class="sell-form__button" type="submit">出品する</button>
    </form>
  </section>

  <script>
    const conditionSelect = document.querySelector('[data-condition-select]');
    const conditionButton = document.querySelector('[data-condition-button]');
    const conditionInput = document.querySelector('[data-condition-input]');
    const conditionList = document.querySelector('[data-condition-list]');
    const conditionOptions = document.querySelectorAll('[data-condition-option]');

    conditionButton.addEventListener('click', () => {
      conditionList.classList.toggle('is-open');
      conditionButton.classList.toggle('is-open');
    });

    conditionOptions.forEach((option) => {
      option.addEventListener('click', () => {
        conditionInput.value = option.value;
        conditionButton.textContent = option.value;

        conditionOptions.forEach((conditionOption) => {
          conditionOption.classList.remove('is-selected');
        });

        option.classList.add('is-selected');
        conditionList.classList.remove('is-open');
        conditionButton.classList.remove('is-open');
      });
    });

    document.addEventListener('click', (event) => {
      if (!conditionSelect.contains(event.target)) {
        conditionList.classList.remove('is-open');
        conditionButton.classList.remove('is-open');
      }
    });
  </script>
@endsection