<?php

namespace App\Services;

use App\Models\FaqCategory;
use App\Models\InquiryForm;
use App\Models\InquiryFormAddition;

class InquiryFormService extends EmbedPartsService
{
    public function store($params)
    {
        return InquiryForm::create($params);
    }

    public function list($params)
    {
        $model = InquiryForm::query()->orderBy('id', 'desc');

        return $model->paginate($params['per_page'] ?? self::DEFAULT_PER_PAGE);
    }

    public function deleteAll($ids)
    {
        return InquiryForm::whereIn('id', $ids)->delete();
    }


    public function syncInquiryFormAdditions(InquiryForm $inquiryForm, $inputInquiryFormAdditions)
    {
        $index = 0;
        $inquiryFormAdditions = [];
        foreach($inputInquiryFormAdditions as $row) {
            if( !is_null($row["field_name"]) && $row["field_name"]!=="" ) {
                $inquiryFormAdditions[] = [
                    'id' => $row["id"] !== "" ? $row["id"] : null,
                    'inquiry_form_id' => $inquiryForm->id,
                    'sort_order' => $index++,
                    'field_name' => $row["field_name"],
                    'field_type' => $row["field_type"],
                    'required' => $row["required"],
                    'contents' => $row["contents"],
                    'remarks' => $row["remarks"],
                ];
            }
        }

        InquiryFormAddition::where('inquiry_form_id', $inquiryForm->id)->delete();
        InquiryFormAddition::upsert($inquiryFormAdditions, ['id']);
    }

    public function getRemarkTypeOptions()
    {
        return [
            ['key' => 1, 'label' => 'プレースホルダとして表示する(入力欄以外には表示されません)'],
            ['key' => 2, 'label' => '入力欄・選択肢の下に表示する']
        ];
    }

    public function getFieldTypeOptions()
    {
        return [
            ['key' => 1, 'label' => 'テキスト'],
            ['key' => 2, 'label' => 'テキストエリア'],
            ['key' => 3, 'label' => 'メールアドレス'],
            ['key' => 4, 'label' => 'ラジオボタン'],
            ['key' => 5, 'label' => 'チェックボックス'],
            ['key' => 6, 'label' => 'プルダウン'],
            ['key' => 7, 'label' => '画像 / PDF'],
            ['key' => 8, 'label' => '日付（時間指定なし）'],
            ['key' => 9, 'label' => '日付（時間指定あり）'],
            ['key' => 10, 'label' => '郵便番号'],
            ['key' => 11, 'label' => '住所'],
        ];
    }

}
