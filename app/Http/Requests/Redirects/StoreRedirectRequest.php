<?php
namespace App\Http\Requests\Redirects;

use App\Http\Requests\FormRequest;
use App\Models\SiteRedirectRecord;
use App\Rules\MaxFullHalfWidth;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class StoreRedirectRequest extends FormRequest
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
            'slug_source' => ['required', 'string', new MaxFullHalfWidth(100), Rule::unique('site_redirect_records')->ignore($this->slug_source) ],
            'slug_target' => ['required', 'string', new MaxFullHalfWidth(100)],
            'status_code' => [
                'required',
                Rule::in([SiteRedirectRecord::STATUS_CODE_301, SiteRedirectRecord::STATUS_CODE_302]),
            ],
            'redirect_start' => ['nullable', 'string'],
            'redirect_end' => ['nullable', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'slug_source.required' => 'パス名を入力してください',
            'slug_source.App\Rules\MaxFullHalfWidth' => '見出しは30文字以内で入力してください',
            'slug_source.unique' => '提供されたスラッグは既に存在します',
            'slug_target.required' => 'パス名を入力してください',
            'slug_target.App\Rules\MaxFullHalfWidth' => '見出しは30文字以内で入力してください',
            'status_code.required' => 'ステータスコードを入力してください',
            'status_code.in' => 'ステータス コードは有効な値である必要があります',
        ];
    }
}
