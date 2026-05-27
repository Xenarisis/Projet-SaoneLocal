<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CurrentPassword;

class DeleteUserRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return auth('api')->user()->can('delete', $this->route('user'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'GoogleToken' => 'sometimes|string',
            'password' => [
                'required_without:GoogleToken',
                'string',
                'max:255',
                new CurrentPassword()
            ]
        ];
    }
}
