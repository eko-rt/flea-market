@extends('layouts.logout_header')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="container">
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
</div>
@endsection