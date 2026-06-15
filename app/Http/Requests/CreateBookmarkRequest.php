<?php

namespace App\Http\Requests;

use App\Models\Bookmark;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class CreateBookmarkRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return Gate::allows('create', Bookmark::class); 
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array {
        return [
            'product_id' => 'required|integer|exists:products,id',
        ];
    }

    /**
     * Get the customized validation error messages.
     */
    public function messages(): array {
        return [
            'product_id.required' => 'Le produit à ajouter aux favoris est obligatoire.',
            'product_id.integer'  => 'L\'identifiant du produit doit être un nombre entier.',
            'product_id.exists'   => 'Ce produit n\'existe pas dans notre base de données.',
        ];
    }
}