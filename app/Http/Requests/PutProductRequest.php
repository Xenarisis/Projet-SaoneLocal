<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PutProductRequest extends FormRequest {
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
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string|max:255',
            'price'         => 'required|numeric|min:0|max:999.99',
            'quantity'      => 'required|integer|min:0',
            'category'      => 'required|string|max:255',
            'subcategory'   => 'nullable|string|max:255'
        ];
    }
}
