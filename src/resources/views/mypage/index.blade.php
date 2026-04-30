@extends('layouts.app')

@push('css')
  <link rel="stylesheet" href="{{ asset('css/pages/mypage/index.css') }}">
@endpush

@section('content')
  <section class="mypage">
    {{-- ユーザー情報 --}}
    <header class="mypage__header">
      <figure class="mypage__avatar-frame">
        @if($user->profile_image)
          <img
            class="mypage__avatar"
            src="{{ asset('storage/' . $user->profile_image) }}"
            alt="{{ $user->name }}"
          >
        @else
          <span class="mypage__avatar-placeholder"></span>
        @endif
      </figure>

      <h2 class="mypage__user-name">{{ $user->name }}</h2>

      <a class="mypage__edit-link" href="{{ route('profile.edit') }}">プロフィールを編集</a>
    </header>

    {{-- マイページタブ --}}
    <nav class="mypage__tabs" aria-label="マイページタブ">
      <a
        class="mypage__tab {{ $page === 'sell' ? 'is-active' : '' }}"
        href="{{ route('mypage.index', ['page' => 'sell']) }}"
      >
        出品した商品
      </a>

      <a
        class="mypage__tab {{ $page === 'buy' ? 'is-active' : '' }}"
        href="{{ route('mypage.index', ['page' => 'buy']) }}"
      >
        購入した商品
      </a>
    </nav>

    {{-- 商品一覧 --}}
    <section class="mypage__content">
      @if($items->isEmpty())
        <p class="mypage__empty">表示できる商品がありません。</p>
      @else
        <ul class="mypage-item-list">
          @foreach($items as $item)
            <li class="mypage-item-list__item">
              <a class="mypage-item-card" href="{{ route('items.show', ['item_id' => $item->id]) }}">
                <figure class="mypage-item-card__image-frame">
                  <img
                    class="mypage-item-card__image"
                    src="{{ filter_var($item->image_path, FILTER_VALIDATE_URL) ? $item->image_path : asset('storage/' . $item->image_path) }}"
                    alt="{{ $item->name }}"
                  >
                </figure>

                <p class="mypage-item-card__name">{{ $item->name }}</p>
              </a>
            </li>
          @endforeach
        </ul>
      @endif
    </section>
  </section>
@endsection