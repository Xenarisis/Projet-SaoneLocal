<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class PutUserRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        $userOrId = $this->route('user');
        $userModel = $userOrId instanceof \App\Models\User ? $userOrId : \App\Models\User::findOrFail($userOrId);
            
        return auth('api')->user()->can('update', $userModel);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        $routeUser = $this->route('user');
        $userId = $routeUser instanceof \App\Models\User ? $routeUser->id : $routeUser;
        
        return [
            'email'         => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($userId)
            ],
            'firstname'     => 'required|string|min:1|max:20',
            'lastname'      => 'required|string|min:1|max:20',
            'username'      => [
                'nullable',
                'string',
                'min:1',
                'max:25',
                Rule::unique('users', 'username')->ignore($userId)
            ],
            'GoogleToken'   => [
                'nullable',
                'string',
                Rule::unique('users', 'GoogleToken')->ignore($userId)
            ],
            'password'      => 'sometimes|string|min:6|max:50'
        ];
    }
}
