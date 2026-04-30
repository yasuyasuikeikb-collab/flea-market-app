@extends('layouts.app')

@push('css')
  <link rel="stylesheet" href="{{ asset('css/pages/sell/create.css') }}">
@endpush

@section('content')
  <section class="sell-page">
    <h2 class="sell-page__title">商品の出品</h2>

    {{-- 商品出品フォーム --}}
    <form class="sell-form" action="{{ route('sell.store') }}" method="post" enctype="multipart/form-data">
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
          <select id="condition" class="sell-form__select" name="condition">
            <option value="">選択してください</option>
            <option value="良好" {{ old('condition') === '良好' ? 'selected' : '' }}>良好</option>
            <option value="目立った傷や汚れなし" {{ old('condition') === '目立った傷や汚れなし' ? 'selected' : '' }}>目立った傷や汚れなし</option>
            <option value="やや傷や汚れあり" {{ old('condition') === 'やや傷や汚れあり' ? 'selected' : '' }}>やや傷や汚れあり</option>
            <option value="状態が悪い" {{ old('condition') === '状態が悪い' ? 'selected' : '' }}>状態が悪い</option>
          </select>

          @error('condition')
            <p class="sell-form__error">{{ $message }}</p>
          @enderror
        </section>
      </section>

      <section class="sell-form__section">
        <h3 class="sell-form__section-title">商品名と説明</h3>

        <section class="sell-form__group">
          <label class="sell-form__heading" for="name">商品名</label>
          <input id="name" class="sell-form__input" type="text" name="name" value="{{ old('name') }}">

          @error('name')
            <p class="sell-form__error">{{ $message }}</p>
          @enderror
        </section>

        <section class="sell-form__group">
          <label class="sell-form__heading" for="brand_name">ブランド名</label>
          <input id="brand_name" class="sell-form__input" type="text" name="brand_name" value="{{ old('brand_name') }}">
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
          <input id="price" class="sell-form__input" type="text" name="price" value="{{ old('price') }}" placeholder="¥">

          @error('price')
            <p class="sell-form__error">{{ $message }}</p>
          @enderror
        </section>
      </section>

      <button class="sell-form__button" type="submit">出品する</button>
    </form>
  </section>
@endsection