<?php

namespace App\Casts\SiteSnsSetting;

use App\Models\ImageFile;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class SnsImageCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        $image = ImageFile::query()->where('filename', $value)->first();
        return optional($image)->id;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        $image = ImageFile::query()->find($value);
        return optional($image)->filename;
    }
}
