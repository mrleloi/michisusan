<?php

namespace App\Services;

use App\Models\Department;
use App\Models\DepartmentAddition;

class DepartmentService extends EmbedPartsService
{
    public function store($params)
    {
        $max = Department::max('sort_order');
        $params['sort_order'] = $max + 1;

        return Department::create($params);
    }

    public function getAll($columns = ['id', 'name'])
    {
        $model = Department::query()->orderBy('sort_order', 'asc');
        if($columns) {
            $model->select($columns);
        }

        return $model->get();
    }

    public function list($params)
    {
        $model = Department::query()->orderBy('sort_order', 'asc')->withCount('staffMembers');

        return $model->paginate($params['per_page'] ?? self::DEFAULT_PER_PAGE);
    }

    public function deleteAll($ids)
    {
        return Department::whereIn('id', $ids)->delete();
    }

}
