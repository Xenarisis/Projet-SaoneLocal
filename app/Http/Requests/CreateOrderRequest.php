<?php

namespace App\Http\Requests;

use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return $this->user()->can('create', Order::class);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array {
        return [
            'order_number'      => 'required|string|max:255|unique:orders,order_number',
            'status'            => 'required|string|max:50|in:pending,paid,shipped,delivered,cancelled',
            'total_excl_tax'    => 'required|numeric|min:0',
            'percentage_tax'    => 'required|numeric|min:0',
            'payment_status'    => 'required|string|max:50' 
        ];
    }

    /**
     * Get the customized validation error messages.
     */
    public function messages(): array {
        return [
            'order_number.required'   => 'Le numéro de commande est obligatoire.',
            'order_number.string'     => 'Le numéro de commande doit être une chaîne de caractères.',
            'order_number.max'        => 'Le numéro de commande ne peut pas dépasser 255 caractères.',
            'order_number.unique'     => 'Ce numéro de commande existe déjà.',
            'status.required'         => 'Le statut est obligatoire.',
            'status.in'               => 'Le statut fourni est invalide. Statuts acceptés : pending, paid, shipped, delivered, cancelled.',
            'total_excl_tax.required' => 'Le total hors taxe est obligatoire.',
            'total_excl_tax.numeric'  => 'Le total hors taxe doit être un nombre.',
            'total_excl_tax.min'      => 'Le total hors taxe ne peut pas être négatif.',
            'percentage_tax.required' => 'Le pourcentage de taxe est obligatoire.',
            'percentage_tax.numeric'  => 'Le pourcentage de taxe doit être un nombre.',
            'percentage_tax.min'      => 'Le pourcentage de taxe ne peut pas être négatif.',
            'payment_status.required' => 'Le statut du paiement est obligatoire.',
            'payment_status.string'   => 'Le statut du paiement doit être une chaîne de caractères.',
            'payment_status.max'      => 'Le statut du paiement ne peut pas dépasser 50 caractères.',
        ];
    }
}