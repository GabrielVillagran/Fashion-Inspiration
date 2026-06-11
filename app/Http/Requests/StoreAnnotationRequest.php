<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAnnotationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tags' => [
                'nullable',
                'string',
                'max:500',
            ],
            'notes' => [
                'nullable',
                'string',
                'max:3000',
            ],
            'observations' => [
                'nullable',
                'string',
                'max:3000',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'tags.max' => 'Tags must not be longer than 500 characters.',
            'notes.max' => 'Notes must not be longer than 3000 characters.',
            'observations.max' => 'Observations must not be longer than 3000 characters.',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if (
                blank($this->input('tags')) &&
                blank($this->input('notes')) &&
                blank($this->input('observations'))
            ) {
                $validator->errors()->add(
                    'annotation',
                    'Please add at least one tag, note, or observation.'
                );
            }
        });
    }
}
