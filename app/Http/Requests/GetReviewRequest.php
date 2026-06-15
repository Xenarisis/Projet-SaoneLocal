<?php

namespace App\Http\Requests;

use App\Models\Review;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class GetReviewRequest extends FormRequest {
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
            'product_id' => 'sometimes|integer|exists:products,id',
            'user_id'    => 'sometimes|integer|exists:users,id',
            'rating'     => 'sometimes|integer|min:1|max:5', 
        ];
    }

    /**
     * Get the customized validation error messages.
     */
    public function messages(): array {
        return [
            'product_id.integer' => 'L\'identifiant du produit doit être un nombre entier.',
            'product_id.exists'  => 'Le produit spécifié n\'existe pas dans notre base de données.',
            'user_id.integer'    => 'L\'identifiant de l\'utilisateur doit être un nombre entier.',
            'user_id.exists'     => 'L\'utilisateur spécifié n\'existe pas dans notre base de données.',
            'rating.integer'     => 'La note doit être un nombre entier.',
            'rating.min'         => 'La note minimale est de 1.',
            'rating.max'         => 'La note maximale est de 5.',
        ];
    }
}