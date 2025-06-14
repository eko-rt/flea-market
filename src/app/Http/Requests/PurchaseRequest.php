<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PurchaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'payment_method_id' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'payment_method_id.required' => '支払い方法を選択してください。',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            redirect()
            ->route('purchase.show',    ['item_id' => $this->route  ('item_id')])
            ->withErrors($validator)
            ->withInput()
        );
    }
}

