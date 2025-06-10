<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ログイン</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">
  @yield('css')
</head>

<body>
  <header class="header">
    <div class="header__inner">
      <a class="header__logo" href="/">
        <img src="{{ asset('images/logo.svg') }}" alt="COACHTECH" width="35" height="35">
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
          <li>
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
              @csrf
              <button type="submit" class="header__nav-link" >
                ログアウト
              </button>
            </form>
          </li>
          <li><a href="{{ route('mypage') }}" class="header__nav-link">マイページ</a></li>
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