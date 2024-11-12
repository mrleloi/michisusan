<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMenuItemRequest extends FormRequest
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
            'menu_category_id' => ['array', 'required'],
            'menu_category_id.*' => ['int'],
            'name' => ['max:250', 'required'],
            'price' => ['max:20', 'required'],
            'append_wave_dash' => ['boolean'],
            'tax_type' => ['min:1', 'max:3'],
            'description' => [],
            'image1_id' => ['exists:image_files,id'],
            'image1_id_delete' => ['boolean'],
            'image2_id' => ['exists:image_files,id'],
            'image2_id_delete' => ['boolean'],
            'image3_id' => ['exists:image_files,id'],
            'image3_id_delete' => ['boolean'],
            'visible' => ['boolean'],
        ];
    }
    
    public function attributes()
    {
        return [
            'name' => 'メニュー名',
            'menu_category_id' => 'カテゴリー名',
            'price' => '金額',
        ];
    }
}
