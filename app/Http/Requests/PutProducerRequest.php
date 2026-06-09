<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class PutProducerRequest extends FormRequest {
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
        $producerId = $this->route('producer')->id;

        return [
            'name'          => [
                'required',
                'string',
                'min:1',
                'max:30',
                Rule::unique('producers', 'name')->ignore($producerId)
            ],
            'presentation'  => 'sometimes|string',
            'street_line_1' => 'required|string|min:1|max:60',
            'street_line_2' => 'nullable|string|min:1|max:60',
            'city'          => 'required|string|min:1|max:50',
            'postal_code'   => 'required|string|min:1|max:20'
        ];
    }
}
