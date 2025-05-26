@extends('layouts.login_header')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
<div class="container purchase-container">
    <div class="purchase-main">
        <!-- 左カラム -->
        <div class="purchase-left">
            <div class="product-image">
                <img src="{{ asset('storage/products-img/' . $product->product_image) }}" alt="商品画像">
            </div>
            <div class="product-info">
                <h1 class="product-name">{{ $product->name }}</h1>
                <p class="product-price">¥{{ number_format($product->price) }}</p>
            </div>
            <hr>
            <form method="POST" action="{{ route('purchase.store', $product->id) }}" class="purchase-form">
                @csrf
                <h2 class="payment-method-title">支払い方法</h2>
                <div class="form-group">
                    <select id="payment_method" name="payment_method" required>
                        <option value="" disabled selected hidden>選択してください</option>
                        <option value="convenience_store">コンビニ払い</option>
                        <option value="credit_card">カード払い</option>
                    </select>
                </div>
                <hr>
                <div class="shipping-address">
                    <div class="shipping-title">配送先 <a href="#" class="change-link">変更する</a></div>
                    <div class="shipping-info">
                        〒 XXX-YYYY<br>
                        ここには住所と連絡先が入ります
                    </div>
                </div>
            </form>
        </div>
        <!-- 右カラム -->
        <div class="purchase-right">
            <div class="summary-box">
                <div class="summary-row">
                    <span>商品代金</span>
                    <span>¥{{ number_format($product->price) }}</span>
                </div>
                <div class="summary-row">
                    <span>支払い方法</span>
                    <span id="selected-method">コンビニ払い</span>
                </div>
            </div>
            <button type="submit" form="purchase-form" class="purchase-btn">購入する</button>
        </div>
    </div>
</div>
@endsection