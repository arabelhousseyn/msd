<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentUpdateRequest extends FormRequest
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
            'title' => ['sometimes', 'string'],
            'folder_id' => ['sometimes', 'uuid', 'exists:folders,id'],
            'file' => ['sometimes', 'file'],
        ];
    }

    public function passedValidation(): void
    {
        $this->merge([
            'format' => $this->file('file')->guessExtension(),
            'size' => $this->file('file')->getSize(),
        ]);
    }


    public function validated($key = null, $default = null): array
    {
        return array_merge(parent::validated(), [
            'format' => $this->file('file')->guessExtension(),
            'size' => $this->file('file')->getSize(),
        ]);
    }
}
