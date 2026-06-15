<?php

namespace App\Http\Requests;

use App\Models\Follow;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class CreateFollowRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return Gate::allows('create', Follow::class);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array {
        return [
            'producer_id' => 'required|integer|exists:producers,id',
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages(): array {
        return [
            'producer_id.required' => 'Le producteur à suivre est obligatoire.',
            'producer_id.integer'  => 'L\'identifiant du producteur doit être un nombre entier.',
            'producer_id.exists'   => 'Ce producteur n\'existe pas dans notre base de données.',
        ];
    }
}