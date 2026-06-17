<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class GetUserRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return $this->user() && $this->user()->can('viewAny', User::class);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array {
        return [
            'id'          => 'sometimes|integer|exists:users,id',
            'email'       => 'sometimes|email|max:255',
            'username'    => 'sometimes|string|max:255',
            'GoogleToken' => 'sometimes|string|max:255',
        ];
    }

    /**
     * Get the customized validation error messages.
     */
    public function messages(): array {
        return [
            'id.integer'         => 'L\'identifiant doit être un nombre entier.',
            'id.exists'          => 'Aucun utilisateur ne correspond à cet identifiant.',
            'email.email'        => 'L\'adresse email fournie n\'est pas valide.',
            'email.max'          => 'L\'adresse email ne peut pas dépasser 255 caractères.',
            'username.string'    => 'Le nom d\'utilisateur doit être une chaîne de caractères.',
            'username.max'       => 'Le nom d\'utilisateur ne peut pas dépasser 255 caractères.',
            'GoogleToken.string' => 'Le token Google doit être une chaîne de caractères.',
            'GoogleToken.max'    => 'Le token Google ne peut pas dépasser 255 caractères.',
        ];
    }
}