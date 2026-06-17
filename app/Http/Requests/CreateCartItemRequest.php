<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCartItemRequest extends FormRequest {
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
            'product_id' => 'required|integer|exists:products,id',
            'quantity'   => 'sometimes|integer|min:1',
        ];
    }

    /**
     * Get the customized validation error messages.
     */
    public function messages(): array {
        return [
            'product_id.required' => 'Le produit est obligatoire pour l\'ajouter au panier.',
            'product_id.integer'  => 'L\'identifiant du produit doit être un nombre.',
            'product_id.exists'   => 'Le produit sélectionné n\'existe pas ou n\'est plus disponible.',
            'quantity.integer'    => 'La quantité doit être un nombre entier.',
            'quantity.min'        => 'La quantité doit être d\'au moins 1.',
        ];
    }
}