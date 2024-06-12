<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
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
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'is_admin' => ['required', 'boolean'],
            'email' => ['required', 'string', 'email', 'unique:users'],
            'company_id' => ['required',  'uuid', 'exists:companies,id'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'position' => ['nullable', 'string'],
            'role' => ['string'],
        ];
    }
}
