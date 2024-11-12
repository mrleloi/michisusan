<?php

namespace App\Services;

use App\Models\InquiryLog;

class InquiryLogService extends EmbedPartsService
{
    public function list($params, $paginate = true)
    {
        $model = InquiryLog::query()->orderBy('id', 'desc')->where('inquiry_form_id', $params['inquiry_form_id']);

        if (isset($params['received_at_from']) && !is_null($params['received_at_from'])) {
            $model->where('received_at', '>=', $params['received_at_from']);
        }

        if (isset($params['received_at_to']) && !is_null($params['received_at_to'])) {
            $model->where('received_at', '<=', $params['received_at_to']);
        }


        if ($paginate) {
            return $model->paginate($params['per_page'] ?? self::DEFAULT_PER_PAGE);
        } else {
            $model->select(['received_at', 'mail_body', 'user_agent', 'ip_address']);
            return $model;
        }
    }

    public function deleteAll($ids)
    {
        return InquiryLog::whereIn('id', $ids)->delete();
    }
}
