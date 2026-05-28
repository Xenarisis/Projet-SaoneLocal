<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PatchOrderRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return auth('api')->user()->can('update', $this->route('order'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'order_number'      => 'sometimes|string|unique:orders,order_number',
            'status'            => 'sometimes|string|max:255',
            'total_excl_tax'    => 'sometimes|numeric|min:0',
            'percentage_tax'    => 'sometimes|numeric|min:0',
            'payment_status'    => 'sometimes|string|max:255'
        ];
    }
}
