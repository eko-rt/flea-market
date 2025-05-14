@extends('layouts.common')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
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
    @auth
    <!-- ログイン時の表示 -->
    <div class="tabs">
        <a href="#" class="tab active">おすすめ</a>
        <a href="#" class="tab">マイリスト</a>
    </div>
    <div class="product-grid">
        @for ($i = 0; $i < 8; $i++)
        <div class="product-card">
            <div class="product-image">
                <img src="{{ asset('images/product-placeholder.png') }}" alt="商品画像">
            </div>
            <div class="product-name">商品名</div>
        </div>
        @endfor
    </div>
    @else
    <!-- ログアウト時の表示 -->
    <div class="product-grid">
        @for ($i = 0; $i < 8; $i++)
        <div class="product-card">
            <div class="product-image">
                <img src="{{ asset('images/product-placeholder.png') }}" alt="商品画像">
            </div>
            <div class="product-name">商品名</div>
        </div>
        @endfor
    </div>
    @endauth
</div>
@endsection