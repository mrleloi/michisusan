<?php

namespace App\Services;

use App\Models\RecruitingCategory;
use App\Models\Recruiting;
use App\Models\RecruitingAddition;
use Illuminate\Support\Arr;

class RecruitingService extends EmbedPartsService
{
    public function store($params)
    {
        $max = Recruiting::max('sort_order');
        $params['sort_order'] = $max + 1;

        $recruiting = Recruiting::create($params);
        $this->syncRecruitingAdditions($recruiting, $params['rows'] ?? []);

        return $recruiting;
    }

    public function getCategoryOfCurrentSite($withDefault = false)
    {
        $result = RecruitingCategory::query()->orderBy('sort_order')->select('id', 'name')->get()->toArray();

        if ($withDefault) {
            return array_merge([['id' => 0, 'name' => 'カテゴリー一覧']], $result);
        } else {
            return $result;
        }
    }

    public function syncRecruitingAdditions(Recruiting $recruiting, $inputRecruitingAdditions)
    {
        $index = 0;
        $recruitingAdditions = [];
        foreach($inputRecruitingAdditions as $row) {
            if( !is_null($row["field_name"]) && $row["field_name"]!=="" ) {
                $recruitingAdditions[] = [
                    'id' => $row["id"] !== "" ? $row["id"] : null,
                    'recruiting_id' => $recruiting->id,
                    'sort_order' => $index++,
                    'field_name' => $row["field_name"],
                    'contents' => $row["contents"],
                ];
            }
        }

        RecruitingAddition::where('recruiting_id', $recruiting->id)->delete();
        RecruitingAddition::upsert($recruitingAdditions, ['id']);
    }

    public function getEmploymentStatusTypes()
    {
        return [
            ['key' => '1', 'label' => '雇用形態1'],
            ['key' => '2', 'label' => '雇用形態2'],
            ['key' => '3', 'label' => '雇用形態3'],
        ];
    }

    public function getSalaryTypes()
    {
        return [
            ['key' => '1', 'label' => '月給1'],
            ['key' => '2', 'label' => '月給2'],
            ['key' => '3', 'label' => '月給3'],
        ];

    }
    public function getMVTextTypes()
    {
        return [
            ['key' => '1', 'label' => '企業名'],
            ['key' => '2', 'label' => 'システム名'],
            ['key' => '3', 'label' => '募集職種名'],
        ];
    }

    public function getButtonLinkTypes()
    {
        return [
            ['key' => '1', 'label' => 'リストから選ぶ'],
            ['key' => '2', 'label' => '直接入力する']
        ];
    }

    public function getButtonLinkOpenTypes()
    {
        return [['key' => '1', 'label' => '同一ウィンドウで開く'], ['key' => '2', 'label' => '別ウィンドウで開く']];
    }

    public function list($params)
    {
        $model = Recruiting::query()->orderBy('sort_order', 'desc')->with('recruitingCategory');

        if (array_key_exists('keyword', $params) && $params['keyword']) {
            $model->where('company_name', 'like', "%{$params['keyword']}%");
        }

        return $model->paginate($params['per_page'] ?? self::DEFAULT_PER_PAGE);
    }

    public function deleteAll($ids)
    {
        return Recruiting::whereIn('id', $ids)->delete();
    }

    public function registerCategory($params)
    {
        $max = RecruitingCategory::max('sort_order');
        $params['sort_order'] = $max + 1;
        $params['visible'] = 1;

        return RecruitingCategory::create($params);
    }

    public function getItemsByCategory($columns = ['id', 'name', 'alias'])
    {
        return RecruitingCategory::whereHas('recruitings', function ($q) {
//            $q->where('visible', false);
        })->select($columns)->orderBy('sort_order', 'asc')
            ->with('recruitings')
            ->get();
    }
}
