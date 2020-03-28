<?php

namespace App\Http\Requests\Supplier;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupplierRequest extends FormRequest
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
            'company_name' => 'required|string|min:2|max:50|unique:suppliers',
            'country' => 'required|string|min:2|max:100',
            'city' => 'required|string|min:2|max:100',
            'state' => 'required|string|min:2|max:100',
            'postcode' => 'required|string|max:5',
            'address' => 'required|string|min:2|max:100',
            'phone' => 'nullable|string|size:11|unique:suppliers',
            'email' => 'required|string|email|max:255|unique:suppliers',
            'logo' => 'nullable',
        ];
    }
}
