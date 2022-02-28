<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'name' => "required|max:200|unique:categories,name,{$this->id}",
            'parent_id' => 'required|integer|min:1',
            'tax_id' => 'required|integer|min:0',
            'description' => 'nullable|max:2000',
            'facebook_category_id' => 'required|integer|min:1',
            'google_category_id' => 'required|integer|min:1',
        ];
    }
}
