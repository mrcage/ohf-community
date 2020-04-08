<?php

namespace App\Http\Requests\Accounting;

use App\Models\Accounting\Wallet;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreWallet extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:191',
                isset($this->wallet)
                    ? Rule::unique('accounting_wallets')->ignore($this->wallet->id)
                    : Rule::unique('accounting_wallets'),
            ],
            'is_default' => [
                'boolean',
            ],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!$this->input('is_default') && $this->wallet->is_default) {
                $validator->errors()->add('is_default', __('accounting.there_must_be_one_default_wallet'));
            }
        });
    }
}
