<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentCreateRequest extends FormRequest
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
            'folder_id' => ['required', 'uuid', 'exists:folders,id'],
            'file' => [
            'sometimes',
            'file',
            'mimes:jpeg,jpg,png,gif,pdf,doc,docx,xls,xlsx,csv,ppt,pptx,txt,rtf,odt,ods,odp,mp4', // Specify allowed file types
            'max:20480', // Adjust size limit if needed (20 MB here)
        ],
            'description' => ['nullable', 'string'],
        ];
    }

    public function passedValidation(): void
    {
        if($this->hasFile('file'))
        {
            $this->merge([
                'format' => $this->file('file')->guessExtension(),
                'size' => $this->file('file')->getSize(),
                'creator_id' => auth()->id(),
            ]);
        }else{
            $this->merge([
                'creator_id' => auth()->id(),
            ]);
        }
    }


    public function validated($key = null, $default = null): array
    {
        if($this->hasFile('file'))
        {
            return array_merge(parent::validated(), [
                'format' => $this->file('file')->guessExtension(),
                'size' => $this->file('file')->getSize(),
                'creator_id' => auth()->id(),
            ]);
        }else{
            return array_merge(parent::validated(), [
                'creator_id' => auth()->id(),
            ]);
        }
    }
}
