<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PutEventRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return $this->user()->can('update', $this->route('event'));
    }

    /**
     * Get the validation rules that apply to the request.
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
            'street_line_1'     => 'required|string|max:60',
            'street_line_2'     => 'nullable|string|max:60',
            'city'              => 'required|string|max:50',
            'postal_code'       => 'required|string|max:20',
            'producer_ids'      => 'nullable|array',
            'producer_ids.*'    => 'integer|exists:users,id'
        ];
    }

    /**
     * Get the customized validation error messages.
     */
    public function messages(): array {
        return [
            'event_name.required'       => 'Le nom de l\'événement est obligatoire.',
            'event_name.min'            => 'Le nom de l\'événement doit contenir au moins 4 caractères.',
            'event_name.unique'         => 'Un événement porte déjà ce nom.',
            'event_date.required'       => 'La date de l\'événement est obligatoire.',
            'event_date.date'           => 'Le format de la date est invalide.',
            'street_line_1.required'    => 'L\'adresse (ligne 1) est obligatoire.',
            'street_line_1.max'         => 'L\'adresse ne doit pas dépasser 60 caractères.',
            'city.required'             => 'La ville est obligatoire.',
            'city.max'                  => 'La ville ne doit pas dépasser 50 caractères.',
            'postal_code.required'      => 'Le code postal est obligatoire.',
            'postal_code.max'           => 'Le code postal ne doit pas dépasser 20 caractères.',
            'producer_ids.array'        => 'La liste des producteurs doit être un tableau.',
            'producer_ids.*.exists'     => 'L\'un des producteurs sélectionnés n\'existe pas.'
        ];
    }
}