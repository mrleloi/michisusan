<?php
namespace App\Behavior;

use App\Models\ChangeLog;
use Illuminate\Support\Facades\Auth;

trait SaveChangeLog
{
    public static function bootSaveChangeLog()
    {
        static::created(function ($model) {
            self::logChange($model, ChangeLog::STATUS_CREATED);
        });

        static::updated(function ($model) {
            self::logChange($model, ChangeLog::STATUS_UPDATED);
        });

        static::deleted(function ($model) {
            self::logChange($model, ChangeLog::STATUS_DELETED);
        });
    }

    protected static function logChange($model, $status)
    {
        $user = Auth::user();

        $tableName = match (get_class($model)) {
            'App\Models\Page' => 'pages',
            'App\Models\NewsArticle' => 'news_articles',
            'App\Models\BlogsPost' => 'blogs_posts',
            default => class_basename($model)
        };

        ChangeLog::create([
            'user_id' => $user->id ?? null,
            'user_name' => $user->name ?? 'System',
            'table_name' => $tableName,
            'record_id' => $model->id,
            'page_title' => $model->title ?? $model->navigation_name ?? $model->name ?? null, // Depending on the model structure
            'status' => $status
        ]);
    }
}
