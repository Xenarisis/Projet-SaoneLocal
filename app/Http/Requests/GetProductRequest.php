<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class GetProductRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return Gate::allows('viewAny', Product::class);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array {
        return [
            'id'            => 'sometimes|integer|exists:products,id',
            'quantity'      => 'sometimes|integer|min:0',
            'category'      => 'sometimes|string|max:255',
            'subcategory'   => 'sometimes|string|max:255',
            'producer_id'   => 'sometimes|integer|exists:producers,id', 
            'min_price'     => 'sometimes|numeric|min:0',
            'max_price'     => 'sometimes|numeric|gte:min_price', 
            'name'          => 'sometimes|string|max:255',
            'description'   => 'sometimes|string|max:1000',
            'producer_name' => 'sometimes|string|max:255',
        ];
    }

    /**
     * Get the customized validation error messages.
     */
    public function messages(): array {
        return [
            'id.integer'            => 'L\'identifiant doit être un nombre entier.',
            'id.exists'             => 'Aucun produit ne correspond à cet identifiant.',
            'quantity.integer'      => 'La quantité doit être un nombre entier.',
            'quantity.min'          => 'La quantité ne peut pas être négative.',
            'category.string'       => 'La catégorie doit être une chaîne de caractères.',
            'category.max'          => 'La catégorie ne peut pas dépasser 255 caractères.',
            'subcategory.string'    => 'La sous-catégorie doit être une chaîne de caractères.',
            'subcategory.max'       => 'La sous-catégorie ne peut pas dépasser 255 caractères.',
            'producer_id.integer'   => 'L\'identifiant du producteur doit être un nombre entier.',
            'producer_id.exists'    => 'Le producteur spécifié n\'existe pas.',
            'min_price.numeric'     => 'Le prix minimum doit être un nombre.',
            'min_price.min'         => 'Le prix minimum ne peut pas être négatif.',
            'max_price.numeric'     => 'Le prix maximum doit être un nombre.',
            'max_price.gte'         => 'Le prix maximum doit être supérieur ou égal au prix minimum.',
            'name.string'           => 'Le nom doit être une chaîne de caractères.',
            'name.max'              => 'Le nom ne peut pas dépasser 255 caractères.',
            'description.string'    => 'La description doit être une chaîne de caractères.',
            'description.max'       => 'La description ne peut pas dépasser 1000 caractères.',
            'producer_name.string'  => 'Le nom du producteur doit être une chaîne de caractères.',
            'producer_name.max'     => 'Le nom du producteur ne peut pas dépasser 255 caractères.',
        ];
    }
}