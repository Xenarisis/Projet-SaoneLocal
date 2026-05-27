<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PatchProductRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return auth('api')->user()->can('update', $this->route('product'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'name'          => 'sometimes|string|max:255',
            'description'   => 'sometimes|string|max:255',
            'price'         => 'sometimes|numeric|min:0|max:999.99',
            'quantity'      => 'sometimes|integer|min:0',
            'category'      => 'sometimes|string|max:255',
            'subcategory'   => 'sometimes|string|max:255'
        ];
    }
}
