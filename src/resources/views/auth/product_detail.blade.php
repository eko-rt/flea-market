


@extends('layouts.common')

@section('css')
<link rel="stylesheet" href="{{ asset('css/product_detail.css') }}">
@endsection

@section('header')
    @auth
        @include('layouts.login_header')
    @else
        @include('layouts.logout_header')
    @endauth
@endsection

@section('content')

<div class="container product-detail-container">
    <div class="product-detail-main">
        <!-- 左：画像 -->
        <div class="product-detail-image">
            <div class="image-inner">
            <img src="{{ asset('storage/products-img/' . $product->product_image) }}" alt="商品画像">
            @if($product->sold_out)
                <span class="sold-ribbon">sold</span>
            @endif
            </div>
        </div>

        <!-- 右：商品情報 -->
        <div class="product-detail-info">
        <h2 class="product-title">{{ $product->name }}</h2>
            <div class="product-brand">{{ $product->brand_name ?? '' }}</div>
            <div class="product-price">
                <span class="yen-sign">￥</span>
                <span class="price-amount">{{ number_format($product->price) }}</span>
                <span class="tax-in">(税込)</span>
            </div>

        <div class="product-actions">
            <div class="action-item">
            <form method="POST"
                action="{{ $product->likes->where('user_id', auth()->id())->count() ? route('product.unlike', $product->id) : route('product.like', $product->id) }}">
                @csrf
                @if($product->likes->where('user_id', auth()->id())->count())
                    @method('DELETE')
                    <button type="submit" class="like-btn liked">
                    <img src="{{ asset('images/star_.png') }}" alt="Like" style="filter: hue-rotate(45deg); width: 24px; height: 24px;">
                    </button>
                @else
                    <button type="submit" class="like-btn">
                    <img src="{{ asset('images/star.png') }}" alt="Like" style="width: 24px; height: 24px;">
                    </button>
                @endif
            </form>
            <div class="count">{{ $product->likes->count() }}</div>
            </div>

            <div class="action-item">
                <img src="{{ asset('images/star.png') }}" class="like-icon" alt="Like">
                <div class="count">{{ $product->comments->count() }}</div>
            </div>
        </div>

            <a href="{{ route('purchase.show', $product->id) }}" class="buy-btn">購入手続きへ</a>

            <div class="product-description">
                <h3>商品説明</h3>
                <p>{{ $product->description }}</p>
            </div>

            <div class="product-meta">
            <h3>商品の情報</h3>
                <div class="category">
                <strong>カテゴリー</strong>
                    @if($product->categories->isNotEmpty())
                        @foreach($product->categories as $cat)
                            <span class="tag">{{ $cat->name }}</span>
                        @endforeach
                    @else
                        <span class="tag">-</span>
                    @endif
                </div>
                <div class="condition">
                    <strong>商品の状態</strong>
                    {{ $product->condition->name ?? '-' }}
                </div>
            </div>

            <div class="product-comments">
                <h3>コメント ({{ $product->comments->count() }})</h3>

                @foreach($product->comments as $comment)
                <div class="comment-box">
                    <div class="comment-header">
                        <div class="user-icon">
                            <img src="{{ asset('storage/profile-img/' . ($comment->user->profile_image ?? 'default.png')) }}"
                            alt="{{ $comment->user->name }}">
                        </div>
                        <div class="user-name">{{ $comment->user->name }}</div>
                    </div>
                    <div class="comment-content">
                    {{ $comment->content }}
                    </div>
                </div>
                @endforeach

                <form method="POST" action="{{ route('comment.store', $product->id) }}">
                    @csrf
                    <span class="comment-title">商品へのコメント</span>
                    <textarea name="body" rows="8"></textarea>
                    @error('body')
                        <span class="error">{{ $message }}</span>
                    @enderror
                    <button type="submit" class="comment-btn">コメントを送信する</button>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection