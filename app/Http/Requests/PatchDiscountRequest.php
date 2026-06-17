<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PatchDiscountRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return $this->user()->can('update', $this->route('discount'));
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array {
        $discountId = $this->route('discount')->id;

        return [
            'discount_percent'  => 'sometimes|numeric|min:0|max:100',
            'code_name'         => [
                'sometimes',
                'string',
                'max:30',
                Rule::unique('discounts', 'code_name')->ignore($discountId)
            ],
            'availibility'      => 'sometimes|date|after:today',
            'max_use'           => 'sometimes|nullable|integer|min:1'
        ];
    }

    /**
     * Get the customized validation error messages.
     */
    public function messages(): array {
        return [
            'discount_percent.numeric'  => 'Le pourcentage doit être un nombre.',
            'discount_percent.min'      => 'Le pourcentage ne peut pas être inférieur à 0.',
            'discount_percent.max'      => 'Le pourcentage ne peut pas dépasser 100.',
            'code_name.string'          => 'Le code doit être une chaîne de caractères.',
            'code_name.max'             => 'Le code ne doit pas dépasser 30 caractères.',
            'code_name.unique'          => 'Ce code de réduction existe déjà.',
            'availibility.date'         => 'Le format de la date est invalide.',
            'availibility.after'        => 'La date de validité doit être dans le futur.',
            'max_use.integer'           => 'Le nombre d\'utilisations doit être un entier.',
            'max_use.min'               => 'Le nombre d\'utilisations doit être au moins de 1.',
        ];
    }
}