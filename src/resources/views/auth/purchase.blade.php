@extends('layouts.login_header')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')

<form 
  id="purchase-form" 
  method="POST" 
  action="{{ route('purchase.store', $product->id) }}" 
  class="purchase-main"
>
  @csrf

  <!-- 左カラム -->
  <div class="purchase-left">
    <div class="product-header">
        <div class="product-image">
            <img 
                src="{{ asset('storage/products-img/' . $product->product_image) }}" 
                alt="商品画像"
            >
        </div>
        <div class="product-info">
            <h1 class="product-name">{{ $product->name }}</h1>
            <p class="product-price">
              <span class="sign">¥ </span>
              <span class="price">{{ number_format($product->price) }}</span>
            </p>
        </div>
    </div>

    <h2 class="payment-method-title">支払い方法</h2>
    <div class="form-group">
    <select id="payment_method" name="payment_method_id" class="payment-method" required>
        <option value="" disabled selected hidden>選択してください</option>
        @foreach($payment_methods as $method)
          <option value="{{ $method->id }}">{{ $method->name }}</option>
        @endforeach
      </select>
    </div>

    <div class="shipping-address">
      <div class="shipping-title">
        配送先 
        <a href={{route('address.edit', $product->id)}} class="change-link">変更する</a>
      </div>
      <div class="shipping-info">
        〒 {{ auth()->user()->post_code }}<br>
        {{ auth()->user()->address }}<br>
        {{ auth()->user()->building_name }}
      </div>
    </div>
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
        <span id="selected-method">—</span>
      </div>
    </div>

    <!-- form="purchase-form" で上の form を参照 -->
    <button type="submit" class="purchase-btn" form="purchase-form">
      購入する
    </button>
  </div>
</form>

<script>
  document.addEventListener('DOMContentLoaded', function(){
    const select = document.getElementById('payment_method');
    const display = document.getElementById('selected-method');
    select.addEventListener('change', function(){
      display.textContent = this.options[this.selectedIndex].text;
    });
  });
</script>
@endsection
