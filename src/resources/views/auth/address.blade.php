@extends('layouts.login_header')

@section('css')
<link rel="stylesheet" href="{{ asset('css/address.css') }}">
@endsection

@section('content')
<div class="address-container">
    <h2 class="address-title">住所の変更</h2>
    <form method="POST" action="{{ route('address.update',$product->id) }}" class="address-form">
        @csrf
        <div class="form-group">
            <label for="post_code">郵便番号</label>
            <input type="text" id="post_code" name="post_code" value="{{ old('post_code', auth()->user()->post_code ?? '') }}">
        </div>
        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" id="address" name="address" value="{{ old('address', auth()->user()->address ?? '') }}">
        </div>
        <div class="form-group">
            <label for="building_name">建物名</label>
            <input type="text" id="building_name" name="building_name" value="{{ old('building_name', auth()->user()->building_name ?? '') }}">
        </div>
        <button type="submit" class="update-btn">更新する</button>
    </form>
</div>
@endsection