<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMenuCategoryRequest extends FormRequest
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
            'name' => ['max:250', 'required'],
            'alias' => ['max:250'],
            'description' => [],
            'image1_id' => ['exists:image_files,id'],
            'image1_id_delete' => ['boolean'],
            'image2_id' => ['exists:image_files,id'],
            'image2_id_delete' => ['boolean'],
            'image3_id' => ['exists:image_files,id'],
            'image3_id_delete' => ['boolean'],
        ];
    }
}
