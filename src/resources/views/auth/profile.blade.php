@extends('layouts.common')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
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
    <h2 class="form-title">プロフィール設定</h2>
    <form method="POST" action="{{ route('profile.update') }}" class="register-form" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="profile-image">
            <img id="profile-img-preview" src="{{ asset('storage/profile-img/' . (auth()->user()->profile_image ?? 'default-profile.png')) }}" alt="プロフィール画像" class="profile-img">
            <input type="file" id="profile_image" name="profile_image" accept="image/*" style="display:none;">
            <button type="button" class="btn btn-secondary" onclick="document.getElementById('profile_image').click();">画像を選択する</button>
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

    <script>
    document.getElementById('profile_image').addEventListener('change', function(e) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('profile-img-preview').src = e.target.result;
        }
        if(this.files[0]) {
            reader.readAsDataURL(this.files[0]);
        }
    });
    </script>
</div>
@endsection