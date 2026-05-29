<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSuggestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Public form — no auth required
    }

    public function rules(): array
    {
        return [
            // Optional submitter info
            'name' => ['nullable', 'string', 'max:150'],
            'designation' => ['nullable', 'string', 'max:150'],

            // Required suggestion body
            'suggestion' => ['required', 'string', 'min:10', 'max:3000'],

            // Optional category selection
            'category' => ['nullable', 'string', 'in:service_improvement,policy,staff_behavior,facilities,processes,other'],
        ];
    }

    public function messages(): array
    {
        return [
            'suggestion.required' => 'Please enter your suggestion or recommendation.',
            'suggestion.min' => 'Your suggestion must be at least 10 characters.',
            'suggestion.max' => 'Your suggestion may not exceed 3,000 characters.',
        ];
    }
}
