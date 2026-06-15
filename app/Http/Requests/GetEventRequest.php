<?php

namespace App\Http\Requests;

use App\Models\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class GetEventRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return Gate::allows('viewAny', Event::class);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array {
        return [
            'event_name'  => 'sometimes|string|max:255',
            'event_date'  => 'sometimes|date',
            'city'        => 'sometimes|string|max:50',
            'postal_code' => 'sometimes|string|max:20',
        ];
    }

    /**
     * Get the customized validation error messages.
     */
    public function messages(): array {
        return [
            'event_name.string'  => 'Le nom de l\'événement doit être une chaîne de caractères.',
            'event_date.date'    => 'La date de l\'événement n\'est pas dans un format valide.',
            'city.string'        => 'La ville doit être une chaîne de caractères.',
            'postal_code.string' => 'Le code postal doit être une chaîne de caractères.',
        ];
    }
}