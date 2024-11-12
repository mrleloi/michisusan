<?php

namespace App\Services;

use App\Models\VideoCategory;

class VideoCategoryService extends EmbedPartsService
{
    public function findById($id)
    {
        return VideoCategory::find($id);
    }

    public function store($params)
    {
        return VideoCategory::create($params);
    }

    public function list($params) {
        $model = VideoCategory::query();

        if (array_key_exists('keyword', $params) && $params['keyword']) {
            $model->where('name', 'like', "%{$params['keyword']}%");
        }

        return $model->paginate($params['per_page'] ?? self::DEFAULT_PER_PAGE);
    }

    public function deleteAll($ids)
    {
        return VideoCategory::whereIn('id', $ids)->delete();
    }
}
