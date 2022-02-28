<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'warehouse_id' => 'required|integer',
            'manager_id' => 'required|integer',
            'name' => 'required',
            'phone' => 'required|max:20',
            'bank_name' => 'required',
            'bank_account' => 'required|max:20',
            'address' => 'required|max:100'
        ];
    }
}
