<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserProfileFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'firstName'       => 'required|min:2|max:64',
            'lastName'        => 'required|min:2|max:64',
            'password'        => 'nullable|min:6|max:64',
            'confirmPassword' => 'nullable|required_unless:password,null|same:password|min:6|max:64',
            'bio'             => 'nullable'
        ];
    }

    public function messages() {
        return [
            'confirmPassword.required_unless' => 'Confirm password is required, If password field exists!',
        ];
    }
}
