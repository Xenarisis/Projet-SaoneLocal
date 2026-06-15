<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatchComposeRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return $this->user()->can('update', $this->route('compose'));
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array {
        return [
            'quantity'      => 'sometimes|integer|min:1',
            'unit_price'    => 'sometimes|decimal:0,3|min:0'
        ];
    }

    /**
     * Get the customized validation error messages.
     */
    public function messages(): array {
        return [
            'quantity.integer'    => 'La quantité doit être un nombre entier.',
            'quantity.min'        => 'La quantité doit être d\'au moins 1.',
            'unit_price.decimal'  => 'Le prix unitaire doit avoir au maximum 3 décimales.',
            'unit_price.min'      => 'Le prix unitaire ne peut pas être négatif.',
        ];
    }
}