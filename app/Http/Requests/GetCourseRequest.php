<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetCourseRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'per_page' => 'integer|nullable|min:1',
            'keyword' => 'string|nullable',
            'page' => 'integer|nullable|min:1',
        ];
    }

    public function prepareForValidation(): void
    {
        if (! $this->has('per_page')) {
            $this->merge([
                'per_page' => config('constants.pagination.default_limit'),
            ]);
        }
        if (! $this->has('page')) {
            $this->merge([
                'page' => config('constants.pagination.first_page'),
            ]);
        }
    }
}
