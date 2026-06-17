<?php

namespace App\Http\Requests;

use App\Models\Reduce;
use Illuminate\Foundation\Http\FormRequest;

class CreateReduceRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return $this->user()->can('create', Reduce::class);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array {
        return [
            'order_id'    => 'required|integer|exists:orders,id',
            'discount_id' => 'required|integer|exists:discounts,id',
        ];
    }

    /**
     * Get the customized validation error messages.
     */
    public function messages(): array {
        return [
            'order_id.required'    => 'La commande est obligatoire.',
            'order_id.integer'     => 'L\'identifiant de la commande doit être un nombre entier.',
            'order_id.exists'      => 'Cette commande n\'existe pas dans notre base de données.',
            'discount_id.required' => 'La réduction est obligatoire.',
            'discount_id.integer'  => 'L\'identifiant de la réduction doit être un nombre entier.',
            'discount_id.exists'   => 'Le code de réduction spécifié n\'existe pas ou n\'est plus valide.',
        ];
    }
}