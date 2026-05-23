@extends('layouts.app')

@push('css')
  <link rel="stylesheet" href="{{ asset('css/pages/items/show.css') }}">
@endpush

@section('content')
  <article class="item-detail">
    {{-- 商品画像 --}}
    <figure class="item-detail__image-frame">
      <img
        class="item-detail__image"
        src="{{ filter_var($item->image_path, FILTER_VALIDATE_URL) ? $item->image_path : asset('storage/' . $item->image_path) }}"
        alt="{{ $item->name }}"
      >
    </figure>

    {{-- 商品詳細 --}}
    <section class="item-detail__content">
      <header class="item-detail__header">
        <h2 class="item-detail__name">{{ $item->name }}</h2>

        @if($item->brand_name)
          <p class="item-detail__brand">{{ $item->brand_name }}</p>
        @endif

        <p class="item-detail__price">
          ¥{{ number_format($item->price) }}<span>（税込）</span>
        </p>
      </header>

      {{-- いいね・コメント --}}
      <section class="item-detail__actions" aria-label="商品リアクション">
        <section class="item-detail__action">
          @auth
            @if($isLiked)
              <form action="{{ route('like.destroy', ['item_id' => $item->id]) }}" method="post">
                @csrf
                @method('delete')
                <button class="item-detail__icon-button" type="submit">
                  <img src="{{ asset('images/icon-heart-active.png') }}" alt="いいね済み">
                </button>
              </form>
            @else
              <form action="{{ route('like.store', ['item_id' => $item->id]) }}" method="post">
                @csrf
                <button class="item-detail__icon-button" type="submit">
                  <img src="{{ asset('images/icon-heart.png') }}" alt="いいね">
                </button>
              </form>
            @endif
          @else
            <img class="item-detail__icon" src="{{ asset('images/icon-heart.png') }}" alt="いいね">
          @endauth

          <p class="item-detail__action-count">{{ $likeCount }}</p>
        </section>

        <section class="item-detail__action">
          <img class="item-detail__icon" src="{{ asset('images/icon-comment.png') }}" alt="コメント">
          <p class="item-detail__action-count">{{ $commentCount }}</p>
        </section>
      </section>

      @if(!$item->purchase)
        <a class="item-detail__purchase-link" href="{{ route('purchase.create', ['item_id' => $item->id]) }}">
          購入手続きへ
        </a>
      @else
        <p class="item-detail__sold-label">Sold</p>
      @endif

      {{-- 商品説明 --}}
      <section class="item-detail__section">
        <h3 class="item-detail__section-title">商品説明</h3>
        <p class="item-detail__description">{{ $item->description }}</p>
      </section>

      {{-- 商品情報 --}}
      <section class="item-detail__section">
        <h3 class="item-detail__section-title">商品の情報</h3>

        <dl class="item-info">
          <dt class="item-info__term">カテゴリー</dt>
          <dd class="item-info__description">
            @foreach($item->categories as $category)
              <span class="item-info__tag">{{ $category->name }}</span>
            @endforeach
          </dd>

          <dt class="item-info__term">商品の状態</dt>
          <dd class="item-info__description">{{ $item->condition }}</dd>
        </dl>
      </section>

      {{-- コメント --}}
      <section class="item-detail__section">
        <h3 class="item-detail__section-title">コメント({{ $commentCount }})</h3>

        @foreach($item->comments as $comment)
          <article class="comment">
            <header class="comment__header">
              <span class="comment__avatar"></span>
              <p class="comment__user-name">{{ $comment->user->name }}</p>
            </header>

            <p class="comment__body">{{ $comment->content }}</p>
          </article>
        @endforeach

        {{-- コメント投稿フォーム --}}
        @auth
          <form class="comment-form" action="{{ route('comment.store', ['item_id' => $item->id]) }}" method="post" novalidate>
            @csrf

            <label class="comment-form__label" for="content">商品へのコメント</label>
            <textarea id="content" class="comment-form__textarea" name="content">{{ old('content') }}</textarea>

            @error('content')
              <p class="comment-form__error">{{ $message }}</p>
            @enderror

            <button class="comment-form__button" type="submit">コメントを送信する</button>
          </form>
        @else
          <form class="comment-form" action="{{ route('login') }}" method="get">
            <label class="comment-form__label" for="guest-content">商品へのコメント</label>
            <textarea id="guest-content" class="comment-form__textarea" name="content"></textarea>

            <button class="comment-form__button" type="submit">コメントを送信する</button>
          </form>
        @endauth
      </section>
    </section>
  </article>
@endsection