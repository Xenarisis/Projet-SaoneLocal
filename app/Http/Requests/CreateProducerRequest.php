<?php

namespace App\Http\Requests;

use App\Models\Producer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class CreateProducerRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return auth('api')->user()->can('create', Producer::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        $producer = $this->route('producer');

        return [
            'name'          => 'required|string|unique:producers|min:1|max:30',
            'presentation'  => 'sometimes|string',
            'street_line_1' => 'required|string|min:1|max:60',
            'street_line_2' => 'nullable|string|min:1|max:60',
            'city'          => 'required|string|min:1|max:50',
            'postal_code'   => 'required|string|min:1|max:20',
            'user_id'       => 'sometimes|integer|exists:users,id'
        ];
    }
}
