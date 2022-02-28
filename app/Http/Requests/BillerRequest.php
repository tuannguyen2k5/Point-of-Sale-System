<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BillerRequest extends FormRequest
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
            'store_id' => 'required|integer|min:1',
            'name' => "required|max:50",
            'email' => "required|max:50",
            'address' => 'required',
            'phone' => 'required|max:20'
        ];
    }
}
