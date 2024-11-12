<?php
namespace App\Http\Requests\Images;

use App\Http\Requests\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class StoreImageRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        return back()->withInput()->withErrors($validator);
    }

    public function rules()
    {
        return [
            'image_file_category_id' => 'nullable|exists:image_file_categories,id',
            'file' => 'required|array|min:1',
            'file.*' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
            'quality' => 'nullable|integer'
        ];
    }

    public function messages()
    {
        return [
            'file.required' => 'ファイルを入力してください',
            'file.*' => '写真の形式が正しくありません',
        ];
    }
}
