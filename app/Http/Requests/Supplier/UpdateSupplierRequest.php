<?php

namespace App\Http\Requests\Supplier;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplierRequest extends FormRequest
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
            'company_name' => 'nullable|string|min:2|max:50',
            'country' => 'nullable|string|min:2|max:100',
            'city' => 'nullable|string|min:2|max:100',
            'state' => 'nullable|string|min:2|max:100',
            'postcode' => 'nullable|string|max:5',
            'address' => 'nullable|string|min:2|max:100',
            'phone' => 'nullable|string|size:11',
            'email' => 'nullable|string|email|max:255',
            'logo' => 'nullable',
        ];
    }
}
