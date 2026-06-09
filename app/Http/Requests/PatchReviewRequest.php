<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatchReviewRequest extends FormRequest {
    public function authorize(): bool {
        $review = $this->route('review');
        return $this->user()->can('update', $review);
    }

    public function rules(): array {
        return [
            'rating'  => 'sometimes|required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:250',
        ];
    }
}