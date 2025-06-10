@extends('layouts.common')


@section('css')
  <link rel="stylesheet" href="{{ asset('css/verify-email.css') }}">
@endsection

@section('content')
<div class="container">
  <p>
    登録していただいたメールアドレスに認証メールを送付しました。<br>
    メール認証を完了してください。
  </p>

    <a href="{{ config('services.mailtrap.inbox_url') }}"
       class="btn verify-btn"
       target="_blank"
       rel="noopener"
       style="display:inline-block; padding:12px 24px; background:#000; color:#fff; border-radius:4px; text-decoration:none; font-weight:500; margin-bottom:16px;">
      認証はこちらから
    </a>

  <form method="POST" action="{{ route('verification.send') }}">
    @csrf
    <button type="submit" class="btn">認証メールを再送信する</button>
  </form>
</div>
@endsection
