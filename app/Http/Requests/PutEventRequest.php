<?php

namespace App\Http\Requests;

use App\Models\Event;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class PutEventRequest extends FormRequest {
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
        $eventId = $this->route('event')->id;

        return [
            'event_name'        => [
                'required',
                'string',
                'min:4',
                Rule::unique('events', 'event_name')->ignore($eventId)
            ],
            'description'       => 'sometimes|string',
            'event_date'        => 'required|date',

            'street_line_1'     => 'required|string|min:1|max:60',
            'street_line_2'     => 'nullable|string|min:1|max:60',
            'city'              => 'required|string|min:1|max:50',
            'postal_code'       => 'required|string|min:1|max:20'
        ];
    }
}
