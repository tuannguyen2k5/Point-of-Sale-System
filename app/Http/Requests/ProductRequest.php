<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductRequest extends FormRequest
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
            'name' => "required|max:200|unique:products,name,{$this->id}",
            'price' => 'required|min:0',
            'quantity' => 'integer|min:0',
            'brand_id' => 'required|integer|min:0',
            'expired_date' => "required",
            'unit_id' => 'required|integer|min:0',
            'barcode' => "required",
            'category_id' => 'required|integer|min:0',
            'created_by' => 'required|integer|min:0',
            'description' => 'nullable|max:2000',
            'photo' => 'nullable|mimes:jpeg,jpg,png,gif',
            'published' => 'boolean'
        ];
    }
}
