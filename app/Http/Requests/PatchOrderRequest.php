<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PatchOrderRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return $this->user()->can('update', $this->route('order'));
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array {
        $orderId = $this->route('order')->id;

        return [
            'order_number'      => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('orders', 'order_number')->ignore($orderId)
            ],
            'status'            => 'sometimes|string|max:50|in:pending,paid,shipped,delivered,cancelled',
            'total_excl_tax'    => 'sometimes|numeric|min:0',
            'percentage_tax'    => 'sometimes|numeric|min:0',
            'payment_status'    => 'sometimes|string|max:50'
        ];
    }

    /**
     * Get the customized validation error messages.
     */
    public function messages(): array {
        return [
            'order_number.string'     => 'Le numéro de commande doit être une chaîne de caractères.',
            'order_number.max'        => 'Le numéro de commande ne peut pas dépasser 255 caractères.',
            'order_number.unique'     => 'Ce numéro de commande existe déjà.',
            'status.in'               => 'Le statut fourni est invalide. Statuts acceptés : pending, paid, shipped, delivered, cancelled.',
            'total_excl_tax.numeric'  => 'Le total hors taxe doit être un nombre.',
            'total_excl_tax.min'      => 'Le total hors taxe ne peut pas être négatif.',
            'percentage_tax.numeric'  => 'Le pourcentage de taxe doit être un nombre.',
            'percentage_tax.min'      => 'Le pourcentage de taxe ne peut pas être négatif.',
            'payment_status.string'   => 'Le statut du paiement doit être une chaîne de caractères.',
            'payment_status.max'      => 'Le statut du paiement ne peut pas dépasser 50 caractères.',
        ];
    }
}