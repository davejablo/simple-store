<?php

namespace App\Http\Requests\Product;

use App\Category;
use App\Supplier;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
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
        $categories = Category::all()->pluck('id');
        $suppliers = Supplier::all()->pluck('id');

        return [
            'name' => 'required|string|min:2|max:50|unique:categories',
            'description' => 'required|string|min:2|max:100',
            'barcode' => 'required|string|min:2|max:100',
            'category_id' => 'required|integer|', Rule::in($categories),
            'supplier_id' => 'required|integer|', Rule::in($suppliers),
            'unit_price' => 'required|numeric|between:0,9999.99',
            'in_stock' => 'required|integer|between:0,100',
            'picture' => 'nullable',
        ];
    }
}
