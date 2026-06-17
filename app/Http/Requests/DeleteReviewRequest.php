<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteReviewRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        $review = $this->route('review');
        return $this->user()->can('delete', $review);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array {
        return [];
    }
}