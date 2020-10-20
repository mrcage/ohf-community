<?php

namespace App\Http\Requests\Accounting;

use App\Support\Accounting\Webling\Entities\Entrygroup;
use Illuminate\Foundation\Http\FormRequest;

class StoreUndoBooking extends FormRequest
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
            //
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->transaction->external_id !== null && Entrygroup::find($this->transaction->external_id) !== null) {
                $validator->errors()->add('controlled_at', __('accounting.transaction_not_updated_external_record_still_exists'));
            }
        });
    }
}
