<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PutProductRequest extends FormRequest {
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
            'name'          => 'required|string|max:255',
            'description'   => 'required|string|max:1000',
            'price'         => 'required|numeric|min:0|max:999.99',
            'quantity'      => 'required|integer|min:0',
            'category'      => 'required|string|max:255',
            'subcategory'   => 'sometimes|nullable|string|max:255',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ];
    }

    /**
     * Get the customized validation error messages.
     */
    public function messages(): array {
        return [
            'name.required'         => 'Le nom du produit est obligatoire.',
            'name.string'           => 'Le nom doit être une chaîne de caractères.',
            'name.max'              => 'Le nom ne peut pas dépasser 255 caractères.',
            'description.required'  => 'La description est obligatoire.',
            'description.string'    => 'La description doit être une chaîne de caractères.',
            'description.max'       => 'La description ne peut pas dépasser 1000 caractères.',
            'price.required'        => 'Le prix est obligatoire.',
            'price.numeric'         => 'Le prix doit être un nombre.',
            'price.min'             => 'Le prix ne peut pas être négatif.',
            'price.max'             => 'Le prix ne peut pas dépasser 999.99.',
            'quantity.required'     => 'La quantité est obligatoire.',
            'quantity.integer'      => 'La quantité doit être un nombre entier.',
            'quantity.min'          => 'La quantité ne peut pas être négative.',
            'category.required'     => 'La catégorie est obligatoire.',
            'category.string'       => 'La catégorie doit être une chaîne de caractères.',
            'category.max'          => 'La catégorie ne peut pas dépasser 255 caractères.',
            'subcategory.string'    => 'La sous-catégorie doit être une chaîne de caractères.',
            'subcategory.max'       => 'La sous-catégorie ne peut pas dépasser 255 caractères.',
        ];
    }
}