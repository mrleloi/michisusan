<?php

namespace App\Services;

use App\Models\Template;
use Illuminate\Support\Str;

class TemplatesService
{
    public function getTemplates(int $limit)
    {
        return Template::paginate($limit);
    }
    
    public function findById(int $id)
    {
        return Template::find($id);
    }
    
    public function update(int $id, array $data)
    {
        return $this->findById($id)->update($data);
    }

    public function destroy(int $id)
    {
        $this->findById($id)->delete();
    }
}
