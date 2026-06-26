<?php

namespace App\Http\Requests;

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
     */
    public function rules(): array {
        return [
            'email'         => 'required|email|unique:users',
            'firstname'     => 'required|string|min:1|max:20',
            'lastname'      => 'required|string|min:1|max:20',
            'username'      => 'required|string|unique:users|min:1|max:25',
            'GoogleToken'   => 'nullable|string|unique:users',
            'password'      => 'required|string|min:6|max:50',
            'pdp'           => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ];
    }

    /**
     * Get the customized validation error messages.
     */
    public function messages(): array {
        return [
            // Email
            'email.required'        => 'L\'adresse e-mail est obligatoire.',
            'email.email'           => 'L\'adresse e-mail doit être une adresse valide.',
            'email.unique'          => 'Cette adresse e-mail est déjà utilisée.',

            'firstname.required'    => 'Le prénom est obligatoire.',
            'firstname.string'      => 'Le prénom doit être une chaîne de caractères.',
            'firstname.min'         => 'Le prénom doit contenir au moins :min caractère.',
            'firstname.max'         => 'Le prénom ne doit pas dépasser :max caractères.',
            
            'lastname.required'     => 'Le nom de famille est obligatoire.',
            'lastname.string'       => 'Le nom de famille doit être une chaîne de caractères.',
            'lastname.min'          => 'Le nom de famille doit contenir au moins :min caractère.',
            'lastname.max'          => 'Le nom de famille ne doit pas dépasser :max caractères.',
            
            'username.required'     => 'Le nom d\'utilisateur est obligatoire.',
            'username.string'       => 'Le nom d\'utilisateur doit être une chaîne de caractères.',
            'username.unique'       => 'Ce nom d\'utilisateur est déjà pris.',
            'username.min'          => 'Le nom d\'utilisateur doit contenir au moins :min caractère.',
            'username.max'          => 'Le nom d\'utilisateur ne doit pas dépasser :max caractères.',
            
            'GoogleToken.string'    => 'Le token Google doit être une chaîne de caractères.',
            'GoogleToken.unique'    => 'Ce compte Google est déjà associé à un autre utilisateur.',
            'password.required'     => 'Le mot de passe est obligatoire.',
            
            'password.string'       => 'Le mot de passe doit être une chaîne de caractères.',
            'password.min'          => 'Le mot de passe doit contenir au moins :min caractères.',
            'password.max'          => 'Le mot de passe ne doit pas dépasser :max caractères.',
            
            'pdp.image'             => 'Le fichier fourni doit être une image.',
            'pdp.mimes'             => 'La photo de profil doit être au format jpeg, png, jpg ou webp.',
            'pdp.max'               => 'La taille de la photo de profil ne doit pas dépasser 2 Mo.'
        ];
    }
}