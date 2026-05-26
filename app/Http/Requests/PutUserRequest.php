<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PutUserRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        $user = $this->route('user');
        
        return $this->user()->can('update', $user);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        $user = $this->route('user');
        
        return [
            'email' => 'required|email|unique:users,email,' . $user->id,
            'firstname' => 'required|string|min:1|max:20',
            'lastname' => 'required|string|min:1|max:20',
            'username' => 'nullable|string|min:1|max:25|unique:users,username,' . $user->id,
            'GoogleToken' => 'nullable|string|unique:users,GoogleToken,' . $user->id,
            'password' => 'sometimes|string|min:6|max:50'
        ];
    }
}
