<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PatchUserRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return $this->user()->can('update', $this->route('user'));
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array {
        $user = $this->route('user');
        
        $userId = $user instanceof User ? $user->id : $user;
        
        return [
            'email'       => [
                'sometimes', 
                'required', 
                'email', 
                Rule::unique('users', 'email')->ignore($userId)
            ],
            'firstname'   => 'sometimes|required|string|min:1|max:20',
            'lastname'    => 'sometimes|required|string|min:1|max:20',
            'username'    => [
                'sometimes', 
                'nullable', 
                'string', 
                'min:1', 
                'max:25', 
                Rule::unique('users', 'username')->ignore($userId)
            ],
            'GoogleToken' => [
                'sometimes', 
                'nullable', 
                'string', 
                Rule::unique('users', 'GoogleToken')->ignore($userId)
            ],
            'password'    => 'sometimes|required|string|min:6|max:50'
        ];
    }

    /**
     * Get the customized validation error messages.
     */
    public function messages(): array {
        return [
            'email.unique'         => 'Cette adresse e-mail est déjà utilisée.',
            'email.email'          => 'Le format de l\'adresse e-mail est invalide.',
            'username.unique'      => 'Ce nom d\'utilisateur est déjà utilisé.',
            'username.max'         => 'Le nom d\'utilisateur ne doit pas dépasser 25 caractères.',
            'firstname.required'   => 'Le prénom est obligatoire.',
            'lastname.required'    => 'Le nom est obligatoire.',
            'password.min'         => 'Le nouveau mot de passe doit comporter au moins 6 caractères.',
            'password.max'         => 'Le mot de passe ne doit pas dépasser 50 caractères.',
            'GoogleToken.unique'   => 'Ce compte Google est déjà associé à un autre profil.',
        ];
    }
}