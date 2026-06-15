<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetCartItemRequest extends FormRequest {
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
            'user_id'    => 'sometimes|integer|exists:users,id',
            'product_id' => 'sometimes|integer|exists:products,id',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array {
        return [
            'user_id.integer'    => 'L\'identifiant de l\'utilisateur doit être un entier.',
            'user_id.exists'     => 'Cet utilisateur n\'existe pas.',
            'product_id.integer' => 'L\'identifiant du produit doit être un entier.',
            'product_id.exists'  => 'Ce produit n\'existe pas.',
        ];
    }
}