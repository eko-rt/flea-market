@extends('layouts.common')

@section('css')
  <!-- 全体のグリッドは index.css を流用 -->
  <link rel="stylesheet" href="{{ asset('css/index.css') }}">
  <!-- マイページ固有のスタイル -->
  <link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('header')
  @auth
    @include('layouts.login_header')
  @else
    @include('layouts.logout_header')
  @endauth
@endsection

@section('content')
<div class="container">
  <!-- プロフィールヘッダー -->
  <div class="mypage-profile">
    <div class="profile-info">
      <img
        src="{{ asset('storage/user-icons/' . (auth()->user()->icon ?? 'default.png')) }}"
        alt="ユーザーアイコン"
        class="profile-icon"
      >
      <span class="username">{{ auth()->user()->name }}</span>
    </div>
    <a href="{{ route('profile') }}" class="btn edit-profile">プロフィールを編集</a>
  </div>

  <!-- タブ -->
  <div class="tabs">
    <a
      href="{{ route('mypage', ['tab' => 'listing']) }}"
      class="tab {{ request('tab') !== 'purchased' ? 'active' : '' }}"
    >出品した商品</a>
    <a
      href="{{ route('mypage', ['tab' => 'purchased']) }}"
      class="tab {{ request('tab') === 'purchased' ? 'active' : '' }}"
    >購入した商品</a>
  </div>

  <!-- 商品グリッド -->
  <div class="product-grid">
    @php
      // コントローラ側で $tab, $listedProducts, $purchasedProducts を渡す
      $items = request('tab') === 'purchased' ? $purchasedProducts : $listedProducts;
    @endphp

    @forelse($items as $product)
      <div class="product-card">
        <a href="{{ route('product.show', $product->id) }}">
          <div class="product-image">
            <img
              src="{{ asset('storage/product-img/' . $product->product_image) }}"
              alt="商品画像"
            >
          </div>
          <div class="product-name">{{ $product->name }}</div>
        </a>
      </div>
    @empty
      <p class="no-items">まだ商品がありません。</p>
    @endforelse
  </div>
</div>
@endsection
