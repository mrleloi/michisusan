<?php

namespace App\Services;

use App\Models\Department;
use App\Models\StaffMember;
use App\Models\StaffMemberAddition;

class StaffMemberService extends EmbedPartsService
{
    public function getDepartmentsOfCurrentSite($withDefault = false)
    {
        $result = Department::query()->orderBy('sort_order')->select('id', 'name')->get()->toArray();

        if ($withDefault) {
            return array_merge([['id' => 0, 'name' => '組織・役職名一覧']], $result);
        } else {
            return $result;
        }
    }

    public function store($params)
    {
        $max = StaffMember::max('sort_order');
        $params['sort_order'] = $max + 1;

        $sm = StaffMember::create($params);
        $this->syncStaffMemberAdditions($sm, $params['rows'] ?? []);

        return $sm;
    }

    public function list($params)
    {
        $model = StaffMember::query()->orderBy('sort_order', 'desc')->with('department');

        if (array_key_exists('department_id', $params) && $params['department_id']) {
            $model->where('department_id', $params['department_id']);
        }

        if (array_key_exists('visible', $params) && isset($params['visible'])) {
            $model->where('visible', $params['visible']);
        }

        if (array_key_exists('keyword', $params) && $params['keyword']) {
            $model->where(function ($q) use ($params) {
                $q->where('name', 'like', "%{$params['keyword']}%")
                    ->orWhere('another_name', 'like', "%{$params['keyword']}%");
            });
        }

        return $model->paginate($params['per_page'] ?? self::DEFAULT_PER_PAGE);
    }

    public function deleteAll($ids)
    {
        return StaffMember::whereIn('id', $ids)->delete();
    }

    public function syncStaffMemberAdditions(StaffMember $StaffMember, $inputStaffMemberAdditions)
    {
        $index = 0;
        $StaffMemberAdditions = [];
        foreach ($inputStaffMemberAdditions as $row) {
            if (!is_null($row["field_name"]) && $row["field_name"] !== "") {
                $StaffMemberAdditions[] = [
                    'id' => $row["id"] !== "" ? $row["id"] : null,
                    'staff_member_id' => $StaffMember->id,
                    'sort_order' => $index++,
                    'field_name' => $row["field_name"],
                    'contents' => $row["contents"],
                ];
            }
        }

        StaffMemberAddition::where('staff_member_id', $StaffMember->id)->delete();
        //\Log::debug("syncStaffMemberAdditions", [$StaffMemberAdditions]);
        StaffMemberAddition::upsert($StaffMemberAdditions, ['id']);
    }

    public function getItems(
        $categorize = true,
        $departmentIds,
        $itemCount = null,
        $siteId,
        $offset = null,
        $columns = ['id', 'name', 'alias']
    ) {
        if ($categorize) {
            $model = Department::whereHas('staffMembers', function ($q) use ($itemCount) {
                $q->where('visible', true)->orderBy('sort_order', 'desc');
            })->select($columns)->orderBy('sort_order', 'asc');

            if($departmentIds) {
                $model->whereIn('id', $departmentIds);
            }

            // TODO: siteId 絞り込み

            $categories =  $model->get();
            $categories->load(['staffMembers' => function ($query) use ($itemCount) {
                $query->orderBy('sort_order', 'asc')->limit($itemCount)
                    ->with('image')
                    ->with('staffMemberAdditions');
            }]);
            return $categories;
        } else {
            $model = StaffMember::query();

            if (is_array($departmentIds)) {
                $model = StaffMember::whereIn('department_id', $departmentIds);
            }

            if (!is_null($itemCount)) {
                $model = $model->limit($itemCount);
            }

            if (is_array($offset)) {
                $model = $model->offset($offset);
            }

            $model->with('image');

            // TODO: siteId 絞り込み

            return [[
                'id' => null,
                'name' => null,
                'alias' => null,
                'staff_members' => $model->get()
            ]];
        }
    }
}
