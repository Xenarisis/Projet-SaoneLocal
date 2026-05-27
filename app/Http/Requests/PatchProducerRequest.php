<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PatchProducerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        $producer = $this->route('producer');

        return auth('api')->user()->can('update', $producer);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        $user = $this->route('producer');

        return [
            'name' => 'required|string|unique:producer|min:1|max:30' . $user->id,
            'presentation' => 'sometime|string',
            'street_line_1' => 'required|string|min:1|max:60',
            'street_line_2' => 'nullable|string|min:1|max:60',
            'city' => 'required|string|min:1|max:50',
            'postal_code' => 'required|string|min:1|max:20'
        ];
    }
}
