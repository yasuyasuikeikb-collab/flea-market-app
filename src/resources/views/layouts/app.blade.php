<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>COACHTECH フリマ</title>

  {{-- 共通CSS --}}
  <link rel="stylesheet" href="{{ asset('css/common/reset.css') }}">
  <link rel="stylesheet" href="{{ asset('css/common/app.css') }}">

  {{-- ページ別CSS --}}
  @stack('css')
</head>
<body>
  {{-- 共通ヘッダー --}}
  <header class="site-header">
    <h1 class="site-header__logo">
      <a class="site-header__logo-link" href="{{ route('items.index') }}">
        <img
          class="site-header__logo-image"
          src="{{ asset('images/logo.png') }}"
          alt="COACHTECH"
        >
      </a>
    </h1>

    <form class="site-header__search" action="{{ route('items.index') }}" method="get">
      <label class="site-header__search-label" for="keyword">商品検索</label>
      <input
        id="keyword"
        class="site-header__search-input"
        type="text"
        name="keyword"
        value="{{ request('keyword') }}"
        placeholder="なにをお探しですか？"
      >
    </form>

    <nav class="site-header__nav" aria-label="グローバルナビゲーション">
      @auth
        <form class="site-header__logout-form" action="{{ route('logout') }}" method="post">
          @csrf
          <button class="site-header__nav-button" type="submit">ログアウト</button>
        </form>
      @else
        <a class="site-header__nav-link" href="{{ route('login') }}">ログイン</a>
      @endauth

      <a class="site-header__nav-link" href="{{ route('mypage.index') }}">マイページ</a>
      <a class="site-header__sell-link" href="{{ route('sell.create') }}">出品</a>
    </nav>
  </header>

  <main class="main">
    @yield('content')
  </main>
</body>
</html>