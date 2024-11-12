<?php

namespace App\Services;

use App\Models\BlogsSns;
use Illuminate\Support\Str;

class BlogsSnsService
{
    public function getAllSns()
    {
        return BlogsSns::query()
            ->where('is_active', true)
            ->get();
    }
}
