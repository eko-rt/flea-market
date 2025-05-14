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
    <div class="tabs">
        @auth
            <a href="#" class="tab active">おすすめ</a>
            <a href="#" class="tab">マイリスト</a>
        @else
            <a href="#" class="tab active">おすすめ</a>
            <a href="#" class="tab">マイリスト</a>
        @endauth
    </div>

    <div class="product-grid">
        @foreach ($products as $product)
        <div class="product-card">
            <div class="products-image">
            <img src="{{ asset('storage/products-img' . $product->product_image) }}" alt="商品画像" width="max">
            </div>
            <div class="product-name">{{ $product->name }}</div>
        </div>
        @endforeach
    </div>
</div>
@endsection