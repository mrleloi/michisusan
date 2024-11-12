<?php

namespace App\Services;

use App\Models\NewsSns;
use Illuminate\Support\Str;

class NewsSnsService
{
    public function getAllSns()
    {
        return NewsSns::query()
            ->where('is_active', true)
            ->get();
    }
}
