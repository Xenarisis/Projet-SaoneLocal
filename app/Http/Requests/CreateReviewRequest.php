<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateReviewRequest extends FormRequest {
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
            'rating'     => 'required|integer|min:1|max:5',
            'comment'    => 'sometimes|nullable|string|max:250',
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages(): array {
        return [
            'product_id.required' => 'Le produit est obligatoire pour laisser un avis.',
            'product_id.exists'   => 'Le produit spécifié est introuvable.',
            'rating.required'     => 'Une note est obligatoire.',
            'rating.integer'      => 'La note doit être un nombre entier.',
            'rating.min'          => 'La note minimale est de 1.',
            'rating.max'          => 'La note maximale est de 5.',
            'comment.max'         => 'Votre commentaire ne peut pas dépasser 250 caractères.',
        ];
    }
}