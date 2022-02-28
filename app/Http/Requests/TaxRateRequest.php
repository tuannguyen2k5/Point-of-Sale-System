<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaxRateRequest extends FormRequest
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
            'name' => "required|max:200|unique:tax_rate,name,{$this->id}",
            'id' => 'required|integer|min:0',
            'description' => 'nullable|max:2000',
            'value' => 'required|min:0',
        ];
    }
}
