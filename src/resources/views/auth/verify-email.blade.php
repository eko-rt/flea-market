@extends('layouts.header')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/verify-email.css') }}">
@endsection

@section('content')
    <div class="verify-email-wrapper">
        <div class="verify-email-box">
            <p class="verify-email-text">
                <span>登録していただいたメールアドレスに認証メールを送付しました。</span>
                <span>メール認証を完了してください。</span>
            </p>

            <a href="{{ config('services.mailtrap.inbox_url') }}"
            class="btn verify-email-btn"
            target="_blank" rel="noopener">
            認証はこちらから
            </a>

        <form method="POST" action="{{ route('verification.send') }}">
        @csrf
            <button type="submit" class="resend-btn">
            認証メールを再送信する
            </button>
        </form>
        </div>
    </div>
@endsection
