<?php

namespace App\Models;

use App\Behavior\SiteMust;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/*class NewsSubnavigation extends Model
{
    use HasFactory;
    use SiteMust;

    protected $fillable = ['site_id', 'name', 'slug', 'order', 'is_active'];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function newsArticles()
    {
        return $this->hasMany(NewsArticle::class, 'subnavigation_id');
    }

    public function newsSettings()
    {
        return $this->hasMany(NewsSetting::class, 'subnavigation_id');
    }
}*/
class NewsSubnavigation extends Model
{
    protected static $fakeData;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if (!static::$fakeData) {
            static::$fakeData = $this->generateFakeData();
        }
    }

    protected function generateFakeData()
    {
        return new Collection([
            (object)[
                'id' => 1,
                'site_id' => 1,
                'name' => 'Subnavigation 1',
                'slug' => 'subnavigation-1',
                'order' => 1,
                'is_active' => true,
            ],
            (object)[
                'id' => 2,
                'site_id' => 1,
                'name' => 'Subnavigation 2',
                'slug' => 'subnavigation-2',
                'order' => 2,
                'is_active' => true,
            ],
            (object)[
                'id' => 3,
                'site_id' => 1,
                'name' => 'Subnavigation 3',
                'slug' => 'subnavigation-3',
                'order' => 3,
                'is_active' => true,
            ],
        ]);
    }

    public static function query()
    {
        return new static();
    }

    public function where($column, $value)
    {
        static::$fakeData = static::$fakeData->where($column, $value);
        return $this;
    }

    public function orderBy($column)
    {
        static::$fakeData = static::$fakeData->sortBy($column);
        return $this;
    }

    public function get()
    {
        return static::$fakeData;
    }

    public function first()
    {
        return static::$fakeData->first();
    }
}
