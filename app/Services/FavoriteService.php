<?php

namespace App\Services;

use App\Models\FavoriteCategory;
use App\Models\Favorite;
use DB;

class FavoriteService extends EmbedPartsService
{
    public function list($params)
    {
        $model = Favorite::query()->orderBy('sort_order', 'desc');

        return $model->paginate($params['per_page'] ?? self::DEFAULT_PER_PAGE);
    }

    public function deleteAll($ids)
    {
        return Favorite::whereIn('id', $ids)->delete();
    }

}
