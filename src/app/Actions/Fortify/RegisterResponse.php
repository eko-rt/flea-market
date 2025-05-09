<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
{
    public function toResponse($request)
    {
        return redirect('/mypage/profile'); // 登録後のリダイレクト先
    }
}