<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>index</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">
  @yield('css')
</head>

<body>
  <header class="header">
    <div class="header__inner">
      <a class="header__logo" href="/">
        <img src="{{ asset('images/logo.svg') }}" alt="Logo" width="35" height="35">
      </a>
      <form class="header__search" method="GET" action="{{ route('products.index') }}">
        @csrf
        <input
          type="text"
          name="keyword"
          placeholder="なにをお探しですか？"
          class="header__search-input"
          value="{{ old('keyword', $keyword ?? '') }}"
          >
      </form>
      <nav class="header__nav">
        <ul class="header__nav-list">
          <li><a href="{{ route('login') }}" class="header__nav-link">ログイン</a></li>
          <li><a href="{{ route('login') }}" class="header__nav-link">マイページ</a></li>
          <li><a href="/sell" class="header__nav-link">出品</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <main>
    @yield('content')
  </main>
</body>

</html>