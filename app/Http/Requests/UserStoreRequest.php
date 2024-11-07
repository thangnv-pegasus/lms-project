<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class UserStoreRequest extends FormRequest
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
        $genders = config('constants.users.gender');
        return [
            'full_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:6|max:25|confirmed',
            'phone' => 'required|size:10|unique:users,phone',
            'address' => 'required|max:255',
            'gender' => 'required|in:' . implode(',', $genders),
            'dob' => 'required|date',
            'class_id' => 'exists:classes,id',
        ];
    }
}
