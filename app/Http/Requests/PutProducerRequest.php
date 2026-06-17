<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PutProducerRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return $this->user()->can('update', $this->route('producer'));
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array {
        $producerId = $this->route('producer')->id;

        return [
            'name'          => [
                'required',
                'string',
                'max:30',
                Rule::unique('producers', 'name')->ignore($producerId)
            ],
            'presentation'  => 'sometimes|nullable|string',
            'street_line_1' => 'required|string|max:60',
            'street_line_2' => 'sometimes|nullable|string|max:60',
            'city'          => 'required|string|max:50',
            'postal_code'   => 'required|string|max:20'
        ];
    }

    /**
     * Get the customized validation error messages.
     */
    public function messages(): array {
        return [
            'name.required'          => 'Le nom du producteur est obligatoire.',
            'name.string'            => 'Le nom doit être une chaîne de caractères.',
            'name.max'               => 'Le nom ne peut pas dépasser 30 caractères.',
            'name.unique'            => 'Un producteur porte déjà ce nom.',
            'presentation.string'    => 'La présentation doit être une chaîne de caractères.',
            'street_line_1.required' => 'L\'adresse (ligne 1) est obligatoire.',
            'street_line_1.string'   => 'L\'adresse doit être une chaîne de caractères.',
            'street_line_1.max'      => 'L\'adresse ne peut pas dépasser 60 caractères.',
            'street_line_2.string'   => 'L\'adresse (ligne 2) doit être une chaîne de caractères.',
            'street_line_2.max'      => 'L\'adresse (ligne 2) ne peut pas dépasser 60 caractères.',
            'city.required'          => 'La ville est obligatoire.',
            'city.string'            => 'La ville doit être une chaîne de caractères.',
            'city.max'               => 'La ville ne peut pas dépasser 50 caractères.',
            'postal_code.required'   => 'Le code postal est obligatoire.',
            'postal_code.string'     => 'Le code postal doit être une chaîne de caractères.',
            'postal_code.max'        => 'Le code postal ne peut pas dépasser 20 caractères.',
        ];
    }
}