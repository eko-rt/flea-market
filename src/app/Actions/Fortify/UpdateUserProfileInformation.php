<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;
use Illuminate\Validation\ValidationException;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  array<string, string>  $input
     */
    public function update(User $user, array $input): void
    {
        // バリデーションルールを定義
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'post_code' => ['required', 'string', 'max:10'], 
            'address' => ['required', 'string', 'max:255'],  
            'building_name' => ['nullable', 'string', 'max:255'], 
        ])->validate();

        // ユーザー情報を保存
        $user->forceFill([
            'name' => $input['name'],
            'post_code' => $input['post_code'], 
            'address' => $input['address'],    
            'building_name' => $input['building_name'], 
        ])->save();
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  array<string, string>  $input
     */
    protected function updateVerifiedUser(User $user, array $input): void
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
