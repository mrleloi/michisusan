<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStaffMemberRequest extends FormRequest
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
            'department_id' => 'required|integer',
            'name' => 'required|max:250',
            'another_name' => 'max:250',
            'image_id' => ['exists:image_files,id'],
            'image_id_delete' => ['boolean'],
            'visible' => ['boolean'],

            'rows.*' => 'required|array',
            'rows.*.id' => '',
            'rows.*.sort_order' => '',
            'rows.*.field_name' => 'required_with:rows.*.contents|max:80',
            'rows.*.contents' => '',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'スタッフ名',
            'another_name' => 'スタッフ別名',
            'image_id' => '画像',
            'visible' => '表示・非表示',

            'rows' => '自由項目[ID]',
            'rows.*.sort_order' => '自由項目[並び順]',
            'rows.*.field_name' => '自由項目[項目名]',
            'rows.*.contents' => '自由項目[内容]',
        ];
    }

    public function messages()
    {
        return [
        ];
    }

    protected function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();

        $validator->setValueNames([
        ]);

        return $validator;
    }
}
