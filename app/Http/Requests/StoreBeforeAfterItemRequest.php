<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBeforeAfterItemRequest extends FormRequest
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
            'title' => ['max:250', 'required'],
            'contents' => [],
            'before_image_id' => ['required', 'exists:image_files,id'],
            'after_image_id' => ['required', 'exists:image_files,id'],
            'visible' => ['boolean'],
        ];
    }
}
