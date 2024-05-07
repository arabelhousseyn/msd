<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'avatar' => ['sometimes', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'first_name' => ['sometimes', 'string'],
            'last_name' => ['sometimes', 'string'],
            'is_admin' => ['sometimes', 'boolean'],
            'email' => ['sometimes', 'string', 'email', 'unique:users'],
            'company_id' => ['sometimes', 'exists:companies,id'],
            'password' => ['sometimes', 'string', 'min:8', 'confirmed'],
            'position' => ['sometimes', 'string'],
        ];
    }
}
