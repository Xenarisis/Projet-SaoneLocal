<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteReviewRequest extends FormRequest {
    public function authorize(): bool {
        $review = $this->route('review');
        return $this->user()->can('delete', $review);
    }

    public function rules(): array {
        return [];
    }
}