<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGarmentImageRequest extends FormRequest
{
    /**
     * Allow this request to be used.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules for uploading a garment image.
     */
    public function rules(): array
    {
        return [
            'image' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
            'designer' => [
                'nullable',
                'string',
                'max:255',
            ],
            'continent' => [
                'nullable',
                'string',
                'max:255',
            ],
            'country' => [
                'nullable',
                'string',
                'max:255',
            ],
            'city' => [
                'nullable',
                'string',
                'max:255',
            ],
            'captured_year' => [
                'nullable',
                'integer',
                'min:1900',
                'max:' . (now()->year + 1),
            ],
            'captured_month' => [
                'nullable',
                'integer',
                'between:1,12',
            ],
        ];
    }

    /**
     * Friendly validation messages.
     */
    public function messages(): array
    {
        return [
            'image.required' => 'Please upload a garment photo.',
            'image.image' => 'The uploaded file must be an image.',
            'image.mimes' => 'The image must be a JPG, JPEG, PNG, or WEBP file.',
            'image.max' => 'The image must not be larger than 5MB.',
        ];
    }
}
