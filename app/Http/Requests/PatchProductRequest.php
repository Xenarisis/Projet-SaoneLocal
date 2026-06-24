<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatchProductRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return $this->user()->can('update', $this->route('product'));
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array {
        return [
            'name'          => 'sometimes|string|max:255',
            'description'   => 'sometimes|string|max:1000',
            'price'         => 'sometimes|numeric|min:0|max:999.99',
            'quantity'      => 'sometimes|integer|min:0',
            'category'      => 'sometimes|string|max:255',
            'subcategory'   => 'sometimes|nullable|string|max:255',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ];
    }

    /**
     * Get the customized validation error messages.
     */
    public function messages(): array {
        return [
            'name.string'           => 'Le nom doit être une chaîne de caractères.',
            'name.max'              => 'Le nom ne peut pas dépasser 255 caractères.',
            'description.string'    => 'La description doit être une chaîne de caractères.',
            'description.max'       => 'La description ne peut pas dépasser 1000 caractères.',
            'price.numeric'         => 'Le prix doit être un nombre.',
            'price.min'             => 'Le prix ne peut pas être négatif.',
            'price.max'             => 'Le prix ne peut pas dépasser 999.99.',
            'quantity.integer'      => 'La quantité doit être un nombre entier.',
            'quantity.min'          => 'La quantité ne peut pas être négative.',
            'category.string'       => 'La catégorie doit être une chaîne de caractères.',
            'category.max'          => 'La catégorie ne peut pas dépasser 255 caractères.',
            'subcategory.string'    => 'La sous-catégorie doit être une chaîne de caractères.',
            'subcategory.max'       => 'La sous-catégorie ne peut pas dépasser 255 caractères.',
        ];
    }
}