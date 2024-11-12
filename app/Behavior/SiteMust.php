<?php
namespace App\Behavior;

use App\Models\Site;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait SiteMust
{
    public static function bootSiteMust()
    {
        static::addGlobalScope('setSite', function (Builder $b) {
            if (Auth::check()) {
                $b->where('site_id', Auth::user()->site_id);
            }
        });

        static::creating(function ($model) {
            if (Auth::check()) {
                $model->site_id = Auth::user()->site_id;
            } else {
                $site = Site::first();
                $model->site_id = $site->id ?? 1;
            }
        });

        static::updating(function ($model) {
            if (Auth::check()) {
                $model->site_id = Auth::user()->site_id;
            } else {
                $site = Site::first();
                $model->site_id = $site->id ?? 1;
            }
        });
    }

    public static function setSite($siteId)
    {
        return static::withoutGlobalScope('setSite')->where('site_id', $siteId);
    }
}
