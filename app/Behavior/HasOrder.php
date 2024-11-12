<?php

namespace App\Behavior;

use Illuminate\Database\Eloquent\Builder;

trait HasOrder
{
    public static function bootHasOrder()
    {
        static::creating(function ($model) {
            if (!$model->order) {
                $model->order = static::max('order') + 1;
            }
        });
    }

    public function scopeOrdered(Builder $query)
    {
        return $query->orderBy('order');
    }
}
