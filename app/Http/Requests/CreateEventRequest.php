<?php

namespace App\Http\Requests;

use App\Models\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class CreateEventRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return Gate::allows('create', Event::class);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array {
        return [
            'event_name'     => 'required|string|max:255|unique:events,event_name',
            'description'    => 'sometimes|nullable|string',
            'event_date'     => 'required|date',
            'street_line_1'  => 'required|string|max:60',
            'street_line_2'  => 'sometimes|nullable|string|max:60',
            'city'           => 'required|string|max:50',
            'postal_code'    => 'required|string|max:20',
            'producer_ids'   => 'sometimes|array',
            'producer_ids.*' => 'integer|exists:producers,id',
        ];
    }

    /**
     * Get the customized validation error messages.
     */
    public function messages(): array {
        return [
            'event_name.required'    => 'Le nom de l\'événement est obligatoire.',
            'event_name.unique'      => 'Un événement portant ce nom existe déjà.',
            'event_date.required'    => 'La date de l\'événement est obligatoire.',
            'event_date.date'        => 'Le format de la date est invalide.',
            'street_line_1.required' => 'L\'adresse (ligne 1) est obligatoire.',
            'street_line_1.max'      => 'L\'adresse ne doit pas dépasser 60 caractères.',
            'city.required'          => 'La ville est obligatoire.',
            'city.max'               => 'Le nom de la ville ne doit pas dépasser 50 caractères.',
            'postal_code.required'   => 'Le code postal est obligatoire.',
            'postal_code.max'        => 'Le code postal ne doit pas dépasser 20 caractères.',
            'producer_ids.array'     => 'Les producteurs doivent être fournis sous forme de liste.',
            'producer_ids.*.integer' => 'L\'identifiant du producteur doit être un nombre.',
            'producer_ids.*.exists'  => 'Un ou plusieurs producteurs sélectionnés n\'existent pas.',
        ];
    }
}