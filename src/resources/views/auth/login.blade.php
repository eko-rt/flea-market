@extends('layouts.header')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="container">
    <h2 class="form-title">ログイン</h2>

    <form method="POST" action="{{ route('login') }}" class="register-form" novalidate>
        @csrf
        <div class="form-group">
            <label for="email">メールアドレス</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}">
            @error('email')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="password">パスワード</label>
            <input id="password" type="password" name="password">
            @error('password')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">ログインする</button>
    </form>

    <div class="form-footer">
        <a href="{{ route('register') }}" class="link">会員登録はこちら</a>
    </div>
</div>
@endsection