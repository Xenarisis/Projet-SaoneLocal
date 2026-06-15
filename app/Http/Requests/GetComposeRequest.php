<?php

namespace App\Http\Requests;

use App\Models\Compose;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class GetComposeRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return Gate::allows('viewAny', Compose::class);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array {
        return [
            'id'         => 'sometimes|integer',
            'order_id'   => 'sometimes|integer|exists:orders,id',
            'product_id' => 'sometimes|integer|exists:products,id',
        ];
    }

    /**
     * Get the customized validation error messages.
     */
    public function messages(): array {
        return [
            'id.integer'          => 'L\'identifiant doit être un nombre entier.',
            'order_id.integer'    => 'L\'identifiant de la commande doit être un nombre entier.',
            'order_id.exists'     => 'Cette commande n\'existe pas.',
            'product_id.integer'  => 'L\'identifiant du produit doit être un nombre entier.',
            'product_id.exists'   => 'Ce produit n\'existe pas.',
        ];
    }
}