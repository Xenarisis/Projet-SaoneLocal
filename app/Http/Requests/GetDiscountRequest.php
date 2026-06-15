<?php

namespace App\Http\Requests;

use App\Models\Discount;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class GetDiscountRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return Gate::allows('viewAny', Discount::class);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array {
        return [
            'discount_percent' => 'sometimes|integer|min:0|max:100', 
            'code_name'        => 'sometimes|string|max:30',
            'availibility'     => 'sometimes|date',
            'max_use'          => 'sometimes|integer|min:1',
        ];
    }

    /**
     * Get the customized validation messages.
     */
    public function messages(): array {
        return [
            'discount_percent.integer' => 'Le pourcentage de réduction doit être un nombre entier.',
            'discount_percent.min'     => 'Le pourcentage ne peut pas être négatif.',
            'discount_percent.max'     => 'Le pourcentage ne peut pas dépasser 100%.',
            'code_name.string'         => 'Le nom du code promo doit être une chaîne de caractères.',
            'code_name.max'            => 'Le nom du code promo ne doit pas dépasser 30 caractères.',
            'availibility.date'        => 'La date de disponibilité n\'est pas dans un format valide.',
            'max_use.integer'          => 'Le nombre d\'utilisations maximum doit être un nombre entier.',
            'max_use.min'              => 'Le nombre d\'utilisations maximum doit être au moins de 1.',
        ];
    }
}