<?php

namespace App\Http\Requests;

use App\Enums\Lang;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateCompanyRequest extends FormRequest
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
            'name' => ['bail','string', 'required', 'max:255'],
            'description' => ['bail','string', 'required'],
            'email' => ['bail','string', 'required', 'email'],
            'phone' => ['bail','string', 'nullable'],
            'address' => ['bail','string', 'nullable'],
            'logo' => ['bail','file', 'image', 'mimes:jpeg,png,jpg', 'max:2048', 'nullable'],
            'language' => ['bail','string', 'nullable', Rule::in(Lang::getValues())],
            'smtp' =>['bail','array', 'nullable'],
            'directions' => ['bail','array', 'nullable'],
            'directions.*' => ['bail','string', 'nullable'],
            'is_external' => ['bail','boolean', 'required'],
        ];
    }
}
