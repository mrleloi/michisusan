<?php

namespace App\Services;

use App\Models\SiteRedirectRecord;

class RedirectService extends EmbedPartsService
{
    public function findById($id)
    {
        return SiteRedirectRecord::find($id);
    }

    public function store($params)
    {
        return SiteRedirectRecord::create($params);
    }

    public function list($params) {
        $model = SiteRedirectRecord::query();

        return $model->paginate($params['per_page'] ?? self::DEFAULT_PER_PAGE);
    }

    public function deleteAll($ids)
    {
        return SiteRedirectRecord::whereIn('id', $ids)->delete();
    }
}
