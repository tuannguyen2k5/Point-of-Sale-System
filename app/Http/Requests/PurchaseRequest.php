<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
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
            'supplier_id' => 'required|integer',
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|min:0',
            'purchased_date' => 'required',
            'note' => 'nullable|max:300'
        ];
    }
}
