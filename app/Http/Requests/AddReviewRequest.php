<?php

namespace App\Http\Requests;

use App\Models\Review;
use Illuminate\Foundation\Http\FormRequest;

class AddReviewRequest extends FormRequest {
    public function authorize(): bool {
        return $this->user()->can('create', Review::class);
    }

    public function rules(): array {
        return [
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:250',
        ];
    }
}