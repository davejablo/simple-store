<?php

namespace App\Http\Requests\User;

use App\Project;
use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterUserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'birth_date' => 'nullable|before:today|after:1920-01-01',
            'phone' => 'nullable|string|size:11|unique:user_profiles',
            'role' => 'required', Rule::in(User::ROLES),
        ];
    }
}