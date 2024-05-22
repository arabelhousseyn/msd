<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
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
            'name' => ['bail','string', 'sometimes', 'max:255'],
            'description' => ['bail','string', 'sometimes'],
            'email' => ['bail','string', 'sometimes', 'email'],
            'color' => ['bail','string', 'nullable'],
            'phone' => ['bail','string', 'sometimes'],
            'address' => ['bail','string', 'sometimes'],
            'logo' => ['bail','file', 'image', 'mimes:jpeg,png,jpg', 'max:2048', 'sometimes'],
            'lang' => ['bail','string', 'sometimes'],
            'smtp' =>['bail','array', 'sometimes'],
            'directions' => ['bail','array', 'sometimes'],
            'directions.*' => ['bail','string', 'sometimes'],
        ];
    }
}
