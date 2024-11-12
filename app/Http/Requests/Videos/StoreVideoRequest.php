<?php
namespace App\Http\Requests\Videos;

use App\Http\Requests\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class StoreVideoRequest extends FormRequest
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
            'video_category_id' => 'nullable|exists:video_categories,id',
            'file' => 'required|mimes:mp4,avi,mov,wmv|max:10240',
        ];
    }

    public function messages()
    {
        return [
            'file.required' => 'ファイルを入力してください',
            'file.mimes' => 'ビデオ形式が正しくありません',
            'file.max' => 'ビデオのサイズは10MBを超えてはなりません',
        ];
    }
}
