<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class FolderCreateRequest extends FormRequest
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
            'title' => ['required', 'string'],
            'user_id' => ['required', 'uuid', 'exists:users,id'],
            'comment' => ['required', 'string'],
            'end_at' => ['required', 'date'],
        ];
    }

    public function passedValidation(): void
    {
        $this->merge([
            'company_id' => User::find($this->input('user_id'))->company_id,
        ]);
    }


    public function validated($key = null, $default = null): array
    {
        return array_merge(parent::validated(), ['company_id' => User::find($this->input('user_id'))->company_id]);
    }
}
