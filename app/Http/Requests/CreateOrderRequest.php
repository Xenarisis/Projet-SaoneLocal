<?php

namespace App\Http\Requests;

use App\Models\Order;
// use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return auth('api')->user()->can('create', Order::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'order_number'      => 'required|string|unique:orders,order_number',
            'status'            => 'required|string|max:255',
            'total_excl_tax'    => 'required|numeric|min:0',
            'percentage_tax'    => 'required|numeric|min:0',
            'payment_status'    => 'required|string|max:255'
        ];
    }
}
