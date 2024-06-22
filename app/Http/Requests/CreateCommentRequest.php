<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCommentRequest extends FormRequest
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
            'description' => ['required', 'string'],
        ];
    }

    public function passedValidation(): void
    {
        $this->merge([
            'creator_id' => auth()->id(),
        ]);
    }


    public function validated($key = null, $default = null): array
    {
        return array_merge(parent::validated(), ['creator_id' => auth()->id()]);
    }
}
