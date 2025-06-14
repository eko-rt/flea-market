<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    // ログインフォーム表示
    public function showForm()
    {
        return view('auth.login');
    }

    // ログイン処理
    public function login(LoginRequest $request)
    {
        $cred = $request->only('email', 'password');
        if (! Auth::attempt($cred, $request->boolean('remember'))) {
            return back()->withInput(['email' => $request->input('email')]);
        }
    
        if (! Auth::user()->hasVerifiedEmail()) {
            Auth::logout();
            return back()->withInput(['email' => $request->input('email')]);
        }
    
        $request->session()->regenerate();
        return redirect()->intended('/mypage');
    }

    // ログアウト処理
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}