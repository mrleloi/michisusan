<?php
namespace App\Services;

class BlogsPostsTranslateService
{
    public function callTranslationService($data)
    {
        $word = $data['translate_word'];

        // sample translation service
        $translations = [
            'タグ' => 'tag',
            'ブログ' => 'blog',
        ];

        return $translations[$word] ?? null;
    }
}
