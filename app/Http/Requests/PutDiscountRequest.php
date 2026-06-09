<?php

namespace App\Http\Requests;

use App\Models\Discount;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PutDiscountRequest extends FormRequest {
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
        $discountId = $this->route('discount')->id;

        return [
            'discount_percent'  => 'required|numeric|min:0|max:100',
            'code_name'         => [
                'required',
                'string',
                'max:30',
                Rule::unique('discounts', 'code_name')->ignore($discountId)
            ],
            'availibility'      => 'required|date|after:today',
            'max_use'           => 'nullable|integer|min:1'
        ];
    }
}
