<?php

namespace App\Http\Requests;

use App\Enums\FolderStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FolderUpdateRequest extends FormRequest
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
            'user_id' => ['sometimes', 'uuid', 'exists:users,id'],
            'comment' => ['sometimes', 'string'],
            'status' => ['sometimes', Rule::in(FolderStatus::getValues())],
            'end_at' => ['sometimes', 'date'],
        ];
    }
}
