<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShowEventRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return $this->user()->can('view', $this->route('event'));
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array {
        return [];
    }
}