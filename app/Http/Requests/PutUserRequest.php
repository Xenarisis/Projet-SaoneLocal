<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PutUserRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        $user = $this->route('user');

        return $user instanceof User && $this->user()->can('update', $user);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array {
        $user = $this->route('user');
        $userId = $user instanceof User ? $user->id : $user;

        return [
            'email' => [
                'required',
                'email',
                'max:255',
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
            'password'      => 'nullable|string|min:6|max:50|confirmed',
            'pdp'           => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'delete_pdp'    => 'nullable|boolean'
        ];
    }

    /**
     * Get the customized validation error messages.
     */
    public function messages(): array {
        return [
            'email.unique'          => 'Cette adresse e-mail est déjà utilisée par un autre utilisateur.',
            'email.required'        => 'L\'adresse e-mail est obligatoire.',
            'username.unique'       => 'Ce nom d\'utilisateur est déjà pris.',
            'username.max'          => 'Le nom d\'utilisateur ne doit pas dépasser 25 caractères.',
            'firstname.required'    => 'Le prénom est requis.',
            'lastname.required'     => 'Le nom est requis.',
            'password.min'          => 'Le mot de passe doit comporter au moins 6 caractères.',
            'password.max'          => 'Le mot de passe ne peut pas dépasser 50 caractères.',
            'password.confirmed'    => 'La confirmation du mot de passe ne correspond pas.',
            'GoogleToken.unique'    => 'Ce compte Google est déjà associé à un autre utilisateur.',
        ];
    }
}