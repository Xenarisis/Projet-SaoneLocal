<?php

namespace App\Http\Requests;

use App\Models\Reduce;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class GetReduceRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return Gate::allows('viewAny', Reduce::class);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array {
        return [
            'code'       => 'sometimes|string|max:255',
            'is_active'  => 'sometimes|boolean',
            'product_id' => 'sometimes|integer|exists:products,id',
            'min_value'  => 'sometimes|numeric|min:0',
            'max_value'  => 'sometimes|numeric|gte:min_value',
        ];
    }

    /**
     * Get the customized validation error messages.
     */
    public function messages(): array {
        return [
            'code.string'        => 'Le code de réduction doit être une chaîne de caractères.',
            'code.max'           => 'Le code de réduction ne doit pas dépasser 255 caractères.',
            'is_active.boolean'  => 'Le statut d\'activation doit être vrai ou faux.',
            'product_id.integer' => 'L\'identifiant du produit doit être un nombre entier.',
            'product_id.exists'  => 'Le produit spécifié n\'existe pas dans notre base de données.',
            'min_value.numeric'  => 'La valeur minimale doit être un nombre.',
            'min_value.min'      => 'La valeur minimale ne peut pas être négative.',
            'max_value.numeric'  => 'La valeur maximale doit être un nombre.',
            'max_value.gte'      => 'La valeur maximale doit être supérieure ou égale à la valeur minimale.',
        ];
    }
}