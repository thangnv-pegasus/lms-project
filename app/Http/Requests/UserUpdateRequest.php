<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class UserUpdateRequest extends FormRequest
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
        $validate = [
            'full_name' => 'required|string',
            'phone' => 'required|size:10',
            'gender' => 'required|in:' . implode(',', $genders),
            'dob' => 'required|date'
        ];

        if(auth()->user() && auth()->user()->role !== User::ROLE_STUDENT){
            Log::info('>>> check valid');
            $roles = config('constants.users.role');
            $validate['class_id'] = 'required|exists:classes,id';
            $validate['role'] = 'required|in:' . implode(',', $roles);
            $validate['email'] = 'required|email|unique:users,email';
        }

        return $validate;
    }
}
