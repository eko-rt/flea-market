<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_image' => ['required', 'image', 'max:2048'],
            'categories' => ['required', 'array', 'min:1'],
            'condition_id' => ['required'],
            'name' => ['required', 'string', 'max:255'],
            'brand_name' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'price' => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'product_image.required' => '商品画像は必須です。',
            'product_image.image' => '画像ファイルを選択してください。',
            'product_image.max' => '画像サイズは2MB以内にしてください。',
            'categories.required' => 'カテゴリーを1つ以上選択してください。',
            'condition_id.required' => '商品の状態を選択してください。',
            'brand_name.max' => 'ブランド名は255文字以内で入力してください。',
            'name.required' => '商品名は必須です。',
            'name.max' => '商品名は255文字以内で入力してください。',
            'description.required' => '商品の説明は必須です。',
            'description.max' => '商品の説明は255文字以内で入力してください。',
            'price.required' => '販売価格は必須です。',
            'price.integer' => '販売価格は数字で入力してください。',
            'price.min' => '販売価格は1円以上にしてください。',
        ];
    }
}