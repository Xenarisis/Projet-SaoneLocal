<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatchReviewRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return $this->user()->can('update', $this->route('review'));
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array {
        return [
            'rating'  => 'sometimes|integer|min:1|max:5',
            'comment' => 'sometimes|nullable|string|max:250',
        ];
    }

    /**
     * Get the customized validation error messages.
     */
    public function messages(): array {
        return [
            'rating.integer'  => 'La note doit être un nombre entier.',
            'rating.min'      => 'La note minimale est de 1.',
            'rating.max'      => 'La note maximale est de 5.',
            'comment.string'  => 'Le commentaire doit être une chaîne de caractères.',
            'comment.max'     => 'Votre commentaire ne peut pas dépasser 250 caractères.',
        ];
    }
}