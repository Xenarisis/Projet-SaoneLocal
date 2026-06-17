<?php

namespace App\Http\Requests;

use App\Models\Follow;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class GetFollowRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return Gate::allows('viewAny', Follow::class);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array {
        return [
            'user_id'     => 'sometimes|integer|exists:users,id',
            'producer_id' => 'sometimes|integer|exists:producers,id',
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages(): array {
        return [
            'user_id.integer'     => 'L\'identifiant de l\'utilisateur doit être un nombre entier.',
            'user_id.exists'      => 'L\'utilisateur spécifié est introuvable.',
            'producer_id.integer' => 'L\'identifiant du producteur doit être un nombre entier.',
            'producer_id.exists'  => 'Le producteur spécifié est introuvable.',
        ];
    }
}