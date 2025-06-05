@extends('layouts.login_header')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')
<div class="listing-container">
  <h2 class="listing-title">商品の出品</h2>

  <form action="{{ route('sell.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="listing-section">
      <h3 class="section-heading">商品画像</h3>
      <div class="image-upload-wrapper">
        <label class="image-upload-box">
          <input type="file" name="image" id="product-image-input" hidden>
          <span id="image-upload-text">画像を選択する</span>
          <img id="product-image-preview" src="" alt="プレビュー画像" style="display: none;">
        </label>
      </div>
    </div>

    <div class="listing-section">
      <h3 class="section-heading">商品の詳細</h3>
      <div class="form-group">
        <label class="form-group-label">カテゴリー</label>
        <div class="categories">
          @foreach($categories as $cat)
          <label class="category-tag">
            <input type="checkbox" name="categories[]" value="{{ $cat->id }}">
            <span class="category-label-text">{{ $cat->name }}</span>
          </label>
          @endforeach
        </div>
      </div>

      <div class="form-group">
        <label for="condition" class="form-group-label">商品の状態</label>
        <select id="condition" name="condition_id" class="form-control">
          <option value="" disabled selected>選択してください</option>
          @foreach($conditions as $condition)
            <option value="{{ $condition->id }}">{{ $condition->name }}</option>
          @endforeach
        </select>
      </div>

      <h3 class="section-heading">商品名と説明</h3>
      <div class="form-group">
        <label for="name" class="form-group-label">商品名</label>
        <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}">
      </div>

      <div class="form-group">
        <label for="brand" class="form-group-label">ブランド名</label>
        <input type="text" id="brand" name="brand_name" class="form-control" value="{{ old('brand_name') }}">
      </div>

      <div class="form-group">
        <label for="description" class="form-group-label">商品の説明</label>
        <textarea id="description" name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
      </div>

      <div class="form-group">
        <label class="form-group-label">販売価格</label>
        <div class="price-input-wrapper">
          <span class="currency-symbol">¥</span>
          <input type="number" name="price" class="form-control price-input" value="{{ old('price') }}">
        </div>
      </div>

      <div class="submit-btn-wrapper">
        <button type="submit" class="submit-btn">出品する</button>
      </div>
    </div>
  </form>
</div>

<script>
  // 画像選択用 input と要素を取得
  const fileInput = document.getElementById('product-image-input');
  const previewImg = document.getElementById('product-image-preview');
  const uploadText = document.getElementById('image-upload-text');

  fileInput.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) {
      // ファイル選択をキャンセルしたとき
      previewImg.src = '';
      previewImg.style.display = 'none';
      uploadText.style.display = 'inline-block';
      return;
    }

    // FileReader で画像を読み込む
    const reader = new FileReader();
    reader.onload = function(evt) {
      previewImg.src = evt.target.result;     // base64 文字列をセット
      previewImg.style.display = 'block';     // プレビューを表示
      uploadText.style.display = 'none';      // 「画像を選択する」テキストを隠す
    };
    reader.readAsDataURL(file);
  });
</script>
@endsection
