@extends('layouts.header')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="container">
    <h2 class="form-title">プロフィール設定</h2>
    <form method="POST" action="/user/profile-information" class="register-form" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="profile-image">
            <img src="{{ asset('images/default-profile.png') }}" alt="プロフィール画像" class="profile-img">
            <button type="button" class="btn btn-secondary">画像を変更する</button>
        </div>

        <div class="form-group">
            <label for="name">ユーザー名</label>
            <input id="name" type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required autofocus>
            @error('name')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="post_code">郵便番号</label>
            <input id="post_code" type="text" name="post_code" value="{{ old('post_code', auth()->user()->post_code) }}" required>
            @error('post_code')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="address">住所</label>
            <input id="address" type="text" name="address" value="{{ old('address', auth()->user()->address) }}">
            @error('address')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="building_name">建物名</label>
            <input id="building_name" type="text" name="building_name" value="{{ old('building_name', auth()->user()->building_name) }}">
            @error('building_name')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">更新する</button>
    </form>
</div>
@endsection