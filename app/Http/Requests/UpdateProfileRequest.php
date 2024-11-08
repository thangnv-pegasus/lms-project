<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
        $gender = config('constants.users.gender');
        return [
            'full_name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|size:10',
            'gender' => 'required|in:' . implode(',', $gender),
            'dob' => 'required|date_format:Y-m-d',
            'address' => 'nullable|max:255',
            'province_id' => 'nullable|exists:provinces,id',
            'district_id' => 'nullable|exists:districts,id',
            'ward_id' => 'nullable|exists:wards,id',
        ];
    }
}
