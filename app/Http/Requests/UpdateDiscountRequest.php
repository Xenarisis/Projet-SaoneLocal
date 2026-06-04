<?php

namespace App\Http\Requests;

use App\Models\Discount;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDiscountRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return $this->user() && $this->user()->can('update', $this->discount);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'discount_percent' => 'sometimes|numeric|min:0|max:100',
            'code_name' => 'sometimes|string|max:10|unique:discounts,code_name,' . $this->discount?->id,
            'availibility' => 'sometimes|date',
            'max_use' => 'nullable|integer|min:1'
        ];
    }
}
