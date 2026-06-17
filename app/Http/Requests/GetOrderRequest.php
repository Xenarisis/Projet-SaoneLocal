<?php

namespace App\Http\Requests;

use App\Models\Order;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class GetOrderRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return Gate::allows('viewAny', Order::class);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array {
        return [
            'order_number' => 'sometimes|string|max:255',
            'user_id'      => 'sometimes|integer|exists:users,id',
            'status'       => 'sometimes|string|in:pending,paid,shipped,delivered,cancelled|max:50', 
            'min_total'    => 'sometimes|numeric|min:0',
            'max_total'    => 'sometimes|numeric|gte:min_total',
        ];
    }

    /**
     * Get the customized validation error messages.
     */
    public function messages(): array {
        return [
            'order_number.string' => 'Le numéro de commande doit être une chaîne de caractères.',
            'order_number.max'    => 'Le numéro de commande ne peut pas dépasser 255 caractères.',
            'user_id.integer'     => 'L\'identifiant de l\'utilisateur doit être un nombre.',
            'user_id.exists'      => 'Cet utilisateur n\'existe pas dans notre base de données.',
            'status.in'           => 'Le statut fourni est invalide. Statuts acceptés : pending, paid, shipped, delivered, cancelled.',
            'min_total.numeric'   => 'Le montant minimum doit être un nombre.',
            'min_total.min'       => 'Le montant minimum ne peut pas être négatif.',
            'max_total.numeric'   => 'Le montant maximum doit être un nombre.',
            'max_total.gte'       => 'Le montant maximum doit être supérieur ou égal au montant minimum.',
        ];
    }
}