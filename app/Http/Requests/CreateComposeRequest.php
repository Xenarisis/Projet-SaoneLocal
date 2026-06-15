<?php

namespace App\Http\Requests;

use App\Models\Compose;
use Illuminate\Foundation\Http\FormRequest;

class CreateComposeRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return $this->user()->can('create', Compose::class);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array {
        return [
            'order_id'      => 'required|integer|exists:orders,id',
            'product_id'    => 'required|integer|exists:products,id',
            'quantity'      => 'required|integer|min:1',
            'unit_price'    => 'required|decimal:0,3|min:0'
        ];
    }

    /**
     * Get the customized validation error messages.
     */
    public function messages(): array {
        return [
            'order_id.required'   => 'La commande est obligatoire.',
            'order_id.integer'    => 'L\'identifiant de la commande doit être un nombre.',
            'order_id.exists'     => 'Cette commande n\'existe pas.',
            'product_id.required' => 'Le produit est obligatoire.',
            'product_id.integer'  => 'L\'identifiant du produit doit être un nombre.',
            'product_id.exists'   => 'Ce produit n\'existe pas.',
            'quantity.required'   => 'La quantité est obligatoire.',
            'quantity.integer'    => 'La quantité doit être un nombre entier.',
            'quantity.min'        => 'La quantité doit être au moins de 1.',
            'unit_price.required' => 'Le prix unitaire est obligatoire.',
            'unit_price.decimal'  => 'Le prix unitaire doit avoir au maximum 3 décimales.',
            'unit_price.min'      => 'Le prix unitaire ne peut pas être négatif.',
        ];
    }
}