<?php

namespace App\Http\Requests;

use App\Models\Producer;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class GetProducerRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return Gate::allows('viewAny', Producer::class);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array {
        return [
            'id'          => 'sometimes|integer|exists:producers,id',
            'name'        => 'sometimes|string|max:255',
            'city'        => 'sometimes|string|max:100',
            'postal_code' => 'sometimes|string|max:20',
        ];
    }

    /**
     * Get the customized validation error messages.
     */
    public function messages(): array {
        return [
            'id.integer'          => 'L\'identifiant doit être un nombre entier.',
            'id.exists'           => 'Aucun producteur ne correspond à cet identifiant.',
            'name.string'         => 'Le nom doit être une chaîne de caractères.',
            'name.max'            => 'Le nom ne peut pas dépasser 255 caractères.',
            'city.string'         => 'La ville doit être une chaîne de caractères.',
            'city.max'            => 'Le nom de la ville ne peut pas dépasser 100 caractères.',
            'postal_code.string'  => 'Le code postal doit être une chaîne de caractères.',
            'postal_code.max'     => 'Le code postal ne peut pas dépasser 20 caractères.',
        ];
    }
}