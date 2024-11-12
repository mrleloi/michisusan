<?php
// kiai_loi.le 2024.09.10 feature/setting_base add start
namespace App\Services;

class NewsArticlesTranslateService
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
// kiai_loi.le 2024.09.10 feature/setting_base add end
