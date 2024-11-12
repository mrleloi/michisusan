<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubnavigationSmartphoneMenu extends Model
{
    protected $table = 'subnavigation_smartphone_menus';

    protected $fillable = [
        'site_id',
        'subnavigation_id',
        'menu_key',
        'link_type',
        'link01',
        'link02',
        'url',
        'media',
        'text',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id');
    }

    public function subnavigation()
    {
        return $this->belongsTo(Subnavigation::class, 'subnavigation_id');
    }
}
