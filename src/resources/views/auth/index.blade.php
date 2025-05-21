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
        <a href="{{ route('products.index') }}"
            class="tab {{ empty($tab ?? '') || $tab ?? ''==='recommend' ? 'active' : '' }}">
            おすすめ
        </a>
        @auth
        <a href="{{ route('products.index', ['page' => 'mylist']) }}"
        class="tab {{ ($tab ?? '') === 'mylist' ? 'active' : '' }}">
        マイリスト
        </a>
        @else
        <a href="{{ route('login') }}"
           class="tab {{ ($tab ?? '') === 'mylist' ? 'active' : '' }}">
            マイリスト
        </a>
        @endauth
    </div>

    <div class="product-grid">
    @foreach ($products as $product)
        <div class="product-card">
            <a href="{{ route('product.show', $product->id) }}">
                <span class="product-image">
                    <img src="{{ asset('storage/products-img/' . $product->product_image) }}" alt="商品画像">
                    @if($product->sold_out)
                        <span class="sold-label">sold</span>
                    @endif
                </span>
                <span class="product-name">{{ $product->name }}</span>
            </a>
        </div>
    @endforeach
    </div>
</div>
@endsection