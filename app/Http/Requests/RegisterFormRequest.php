<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterFormRequest extends FormRequest
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
            'email'           => 'required|email|min:4|max:256|unique:users',
            'password'        => 'required|min:6|max:64',
            'confirmPassword' => 'required|same:password|min:6|max:64',
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages() {
        return [
            'firstName.required' => 'First Name is required!',
            'firstName.min' => 'First Name must be between 3 to 64 characters!',
            'lastName.required' => 'Last Name is required!',
            'lastName.min' => 'Last Name must be between 3 to 64 characters!',
        ];
    }
}
