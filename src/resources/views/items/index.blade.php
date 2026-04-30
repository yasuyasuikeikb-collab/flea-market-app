@extends('layouts.app')

@push('css')
  <link rel="stylesheet" href="{{ asset('css/pages/items/index.css') }}">
@endpush

@section('content')
  <section class="item-index">
    {{-- 商品一覧タブ --}}
    <nav class="item-index__tabs" aria-label="商品一覧タブ">
      <a
        class="item-index__tab {{ request('tab') !== 'mylist' ? 'is-active' : '' }}"
        href="{{ route('items.index', ['keyword' => request('keyword')]) }}"
      >
        おすすめ
      </a>

      <a
        class="item-index__tab {{ request('tab') === 'mylist' ? 'is-active' : '' }}"
        href="{{ route('items.index', ['tab' => 'mylist', 'keyword' => request('keyword')]) }}"
      >
        マイリスト
      </a>
    </nav>

    {{-- 商品一覧 --}}
    <section class="item-index__content">
      @if($items->isEmpty())
        <p class="item-index__empty">表示できる商品がありません。</p>
      @else
        <ul class="item-list">
          @foreach($items as $item)
            <li class="item-list__item">
              <a class="item-card" href="{{ route('items.show', ['item_id' => $item->id]) }}">
                <figure class="item-card__image-frame">
                  <img
                    class="item-card__image"
                    src="{{ filter_var($item->image_path, FILTER_VALIDATE_URL) ? $item->image_path : asset('storage/' . $item->image_path) }}"
                    alt="{{ $item->name }}"
                  >

                  @if($item->purchase)
                    <figcaption class="item-card__sold">Sold</figcaption>
                  @endif
                </figure>

                <p class="item-card__name">{{ $item->name }}</p>
              </a>
            </li>
          @endforeach
        </ul>
      @endif
    </section>
  </section>
@endsection