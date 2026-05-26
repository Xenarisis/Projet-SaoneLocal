<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'email'         => 'required|email|unique:users',
            'firstname'     => 'required|string|min:1|max:20',
            'lastname'      => 'required|string|min:1|max:20',
            'username'      => 'nullable|string|unique:users|min:1|max:25',
            'GoogleToken'   => 'nullable|string|unique:users',
            'password'      => 'required|string|min:6|max:50'
        ];
    }
}
