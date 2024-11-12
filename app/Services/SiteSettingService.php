<?php

namespace App\Services;

use DB;
use Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Traits\UploadFileTraits;
use App\Models\Site;

class SiteSettingService
{

    use UploadFileTraits;

    public function getSeoTitleSeparators()
    {
        return [['key' => '|', 'label' => '|'], ['key' => '-', 'label' => '-'], ['key' => '<', 'label' => '<']];
    }

    public function getWWWPatterns()
    {
        return [
            ['key' => '1', 'label' => 'www無し (www有りから無しにリダイレクト)'],
            ['key' => '2', 'label' => 'www有り (www無しから有りにリダイレクト)'],
            ['key' => '3', 'label' => '両方 (wwwありなしどちらでもアクセス可)']
        ];
    }

    public function getCookiePolicies()
    {
        return [
            ['key' => '0', 'label' => '表示しない'],
            ['key' => '1', 'label' => 'フッターナビに表示'],
        ];
    }

    public function getIndustryOptions()
    {
        return [
            ['id' => '飲食業', 'name' => '飲食業'],
            ['id' => '建設業', 'name' => '建設業'],
        ];
    }

    public function getHeaderLayoutOptions()
    {
        return [
            ['id' => '1', 'name' => 'pattern1'],
            ['id' => '2', 'name' => 'pattern2'],
            ['id' => '3', 'name' => 'pattern3'],
            ['id' => '4', 'name' => 'pattern4'],
        ];
    }

    public function getMvOverlayOptions()
    {
        return [
            ['id' => '0', 'name' => 'MVにヘッダーがかからない（デフォルト）'],
            ['id' => '1', 'name' => 'MVにヘッダーがかかる'],
        ];
    }

    public function getHeaderScrollOptions()
    {
        return [
            ['id' => '1', 'name' => 'ヘッダーがスクロールに追従する（デフォルト）'],
            ['id' => '0', 'name' => 'ヘッダーがスクロールに追従しない'],
        ];
    }

    public function getHeaderWidthOptions()
    {
        return [
            ['id' => '1', 'name' => '固定（デフォルト）'],
            ['id' => '2', 'name' => '全幅'],
        ];
    }

    public function getTitleFontOptions()
    {
        return [
            ['id' => '1', 'name' => 'ゴシック'],
            ['id' => '2', 'name' => '明朝'],
        ];
    }

    public function getBodyFontOptions()
    {
        return [
            ['id' => '1', 'name' => 'ゴシック'],
            ['id' => '2', 'name' => '明朝'],
        ];
    }

    public function getLoadingAnimationOptions()
    {
        return [
            ['id' => '1', 'name' => '円形+フェードイン'],
            ['id' => '2', 'name' => '円形+スライドアップ'],
            ['id' => '3', 'name' => 'バー+スライドアップ'],
            ['id' => '4', 'name' => '円形+アニメーションスライド'],
            ['id' => '5', 'name' => 'バー+スライドアップダウン'],
            ['id' => '6', 'name' => 'バー+ぼかし'],
            ['id' => '7', 'name' => 'バー+サークル'],
            ['id' => '8', 'name' => 'バー+ドットアニメーション'],
            ['id' => '9', 'name' => 'バー+弧スライドダウン'],
            ['id' => '10', 'name' => 'シャッター'],
        ];
    }

    public function getLoadingAnimationEnabledOptions()
    {
        return [
            ['key' => '1', 'label' => '表示する'],
            ['key' => '0', 'label' => '表示しない'],
        ];
    }

    public function getImageDisplayTypeOptions()
    {
        return [
            ['key' => '1', 'label' => '通常'],
            ['key' => '2', 'label' => 'WebP形式で表示 (一部 / pictureタグ対応)'],
            ['key' => '3', 'label' => 'WebP形式で表示 (全て / ブラウザ判別)'],
        ];
    }

    public function getImagePopupOptions()
    {
        return [
            ['key' => '1', 'label' => 'ON'],
            ['key' => '0', 'label' => 'OFF'],
        ];
    }

    public function getElementAlignmentOptions()
    {
        return [
            ['key' => '1', 'label' => '左揃え'],
            ['key' => '2', 'label' => '中央揃え'],
            ['key' => '3', 'label' => '右揃え'],
        ];
    }

    public function getElementFadeinOptions()
    {
        return [
            ['key' => '0', 'label' => 'なし'],
            ['key' => '1', 'label' => '左から'],
            ['key' => '2', 'label' => '右から'],
            ['key' => '3', 'label' => '上から'],
            ['key' => '4', 'label' => '下から'],
        ];
    }

    public function getNoimageGrayscaleOptions()
    {
        return [
            ['key' => '1', 'label' => 'する'],
            ['key' => '0', 'label' => 'しない'],
        ];
    }

    public function getFooterLayoutOptions()
    {
        return [
            ['id' => '1', 'name' => 'pattern1：中央揃え'],
            ['id' => '2', 'name' => 'pattern2：ナビゲーション（並列）が左・ロゴが右'],
            ['id' => '3', 'name' => 'pattern3：ロゴが左・ナビゲーション（並列）が右'],
            ['id' => '4', 'name' => 'pattern4：ナビゲーション（縦列）が左・ロゴが右'],
            ['id' => '5', 'name' => 'pattern5：ロゴが左・ナビゲーション（縦列）が右'],
        ];
    }

    public function getFooterWidthOptions()
    {
        return [
            ['id' => '1', 'name' => '固定（デフォルト）'],
            ['id' => '2', 'name' => '全幅'],
        ];
    }

    public function updateGeneral(Site $site, array $data, array $files)
    {
        $storage_name = 'public';
        $image_keys = ['favicon_image', 'apple_touch_icon_image'];
        foreach ($image_keys as $key) {
            $clear_key = 'clear_' . $key;
            if (isset($data[$clear_key]) && $data[$clear_key] && $site->$key) {
                try {
                    $this->deleteFromStorage($storage_name, null, $site->$key);
                } catch (Exception $e) {
                    Log::warn($e);
                }
                $data[$key] = null;
            }
        }
        foreach ($files as $key => $file) {
            $file_name = $file->getClientOriginalName();
            $file_size = $file->getSize();
            $uuid = (string) Str::uuid();

            $ext = $file->getClientOriginalExtension();
            $filename = $uuid . '.' . $ext;
            $path = $this->uploadStorage($storage_name, $key, $filename, $file);
            $data[$key] = $path;
        }
        return DB::transaction(function () use ($site, $data) {
            $site->update($data);
            return $site;
        });
    }

    public function updateInitial(Site $site, array $data)
    {
        // TODO: 初期ページ構成の構築
        return DB::transaction(function () use ($site, $data) {
            $site->update($data);
            return $site;
        });
    }

    public function updateAppearance(Site $site, array $data)
    {
        return DB::transaction(function () use ($site, $data) {
            $site->update($data);
            return $site;
        });
    }

    public function updateEmbeddedScript(Site $site, array $data)
    {
        return DB::transaction(function () use ($site, $data) {
            $site->update($data);
            return $site;
        });
    }

    public function updateSitemap(Site $site, array $data)
    {
        return DB::transaction(function () use ($site, $data) {
            $site->update($data);
            return $site;
        });
    }

    public function updateAnalytic(Site $site, array $data)
    {
        return DB::transaction(function () use ($site, $data) {
            $site->update($data);
            return $site;
        });
    }

    public function updateAdvanced(Site $site, array $data)
    {
        return DB::transaction(function () use ($site, $data) {
            $site->update($data);
            return $site;
        });
    }
}
