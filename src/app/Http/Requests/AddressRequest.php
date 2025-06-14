<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'post_code' => ['required', 'regex:/^\d{3}-\d{4}$/', 'size:8'],
            'address' => ['required', 'string', 'max:255'],
            'building' => ['string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'お名前を入力してください。',
            'post_code.required' => '郵便番号を入力してください。',
            'post_code.regex' => '郵便番号はハイフンありの8文字（例: 123-4567）で入力してください。',
            'post_code.size' => '郵便番号は8文字で入力してください。',
            'address.required' => '住所を入力してください。',
        ];
    }
}
