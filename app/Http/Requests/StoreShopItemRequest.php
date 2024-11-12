<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreShopItemRequest extends FormRequest
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
            //address_typeによる条件分岐あり
            'name' => 'required|max:80',
            'zip1' => 'nullable|size:3',
            'zip2' => 'nullable|size:4',
            'address_type' => 'integer',
            'address1' => 'max:80',
            'address2' => 'max:80',
            'prefecture' => 'max:80',
            'city' => 'max:80',
            'town' => 'max:80',
            'building' => 'max:80',
            'map_type' => 'required|integer',
            'tel_no' => 'nullable|regex:/^[0-9]{1,4}-[0-9]{1,4}-[0-9]{1,4}+$/',
            'fax_no' => 'nullable|regex:/^[0-9]{1,4}-[0-9]{1,4}-[0-9]{1,4}+$/',
            'image_id' => '',
            'sign_logo_image_id' => '',
            'description' => '',

            'rows.*' => 'array',
            'rows.*.id' => '',
            'rows.*.sort_order' => '',
            'rows.*.field_name' => 'required_with:rows.*.contents|max:80',
            'rows.*.contents' => '',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => '企業・店舗名',
            'zip1' => '郵便番号1',
            'zip2' => '郵便番号2',
            'address_type' => '住所タイプ',
            'address1' => '住所1',
            'address2' => '住所2',
            'prefecture' => '都道府県',
            'city' => '市区町村',
            'town' => '町域・番地',
            'building' => '建物・ビル名',
            'map_type' => '地図タイプ',
            'tel_no' => '電話番号',
            'fax_no' => 'FAX番号',
            'image_id' => '画像',
            'sign_logo_image_id' => '署名パーツ用ロゴ',
            'description' => '署名パーツ用説明',

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
            'address_type' => [
                '1' => '簡易',
                '2' => '詳細',
            ],
        ]);

        return $validator;
    }
}
