<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class PatchEventRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return auth('api')->user()->can('update', $this->route('event'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'event_name'        => 'sometimes|string|min:4',
            'description'       => 'sometimes|string',
            'event_date'        => 'sometimes|date',
            'street_line_1'     => 'sometimes|string|min:1|max:60',
            'street_line_2'     => 'nullable|string|min:1|max:60',
            'city'              => 'sometimes|string|min:1|max:50',
            'postal_code'       => 'sometimes|string|min:1|max:20'
        ];
    }
}
