<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskStoreRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf|max:5000', // file-size: 5MB, file-type: pdf
            'task_type' => [
                'required',
                'integer',
                'min:1',
                'max:4'
            ], // 1-notify, 2-quizz, 3-exercise, 4-resource, 5-link
            'lesson_id' => 'required|integer|exists:lessons,id',
        ];
    }
}
