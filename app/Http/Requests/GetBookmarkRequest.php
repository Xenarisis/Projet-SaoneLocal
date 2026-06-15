<?php

namespace App\Http\Requests;

use App\Models\Bookmark;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class GetBookmarkRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        // return Gate::allows('viewAny', Bookmark::class);
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array {
        return [
            'user_id'    => 'sometimes|integer|exists:users,id',
            'product_id' => 'sometimes|integer|exists:products,id',
        ];
    }

    /**
     * Get the customized validation error messages.
     */
    public function messages(): array {
        return [
            'user_id.integer'    => 'L\'identifiant de l\'utilisateur doit être un nombre entier.',
            'user_id.exists'     => 'Cet utilisateur n\'existe pas dans notre base de données.',
            'product_id.integer' => 'L\'identifiant du produit doit être un nombre entier.',
            'product_id.exists'  => 'Ce produit n\'existe pas dans notre base de données.',
        ];
    }
}