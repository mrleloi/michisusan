<?php

namespace App\Services;

use App\Models\Subnavigation;
use App\Models\SubnavigationSmartphoneMenu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NavigationService extends EmbedPartsService
{
    public function findById($id)
    {
        return Subnavigation::find($id);
    }

    public function store($params)
    {
        try {
            return DB::transaction(function () use ($params) {
                $subnavigation = Subnavigation::create($params);
                $subnavigationId = $subnavigation->id;
                $menuKeys = ['menu1', 'menu2', 'menu3', 'menu4'];

                foreach ($menuKeys as $menuKey) {
                    if ($params["link01_$menuKey"] || $params["link02_$menuKey"]) {
                        SubnavigationSmartphoneMenu::create([
                            'site_id' => $subnavigation->site_id,
                            'subnavigation_id' => $subnavigationId,
                            'menu_key' => $menuKey,
                            'link_type' => $params["link_type_$menuKey"],
                            'link01' => $params["link01_$menuKey"],
                            'link02' => $params["link02_$menuKey"],
                            'url' => $params["url_$menuKey"],
                            'media' => $params["media_$menuKey"],
                            'text' => $params["text_$menuKey"],
                        ]);
                    }
                }

                return true;
            });

        } catch (\Exception $e) {
            Log::error("Stack trace: " . $e->getTraceAsString());
            return false;
        }
    }

    public function update($params, $navigation)
    {
        try {
            return DB::transaction(function () use ($navigation, $params) {
                $navigation->update($params);
                $subnavigationId = $navigation->id;
                $menuKeys = ['menu1', 'menu2', 'menu3', 'menu4'];

                foreach ($menuKeys as $menuKey) {
                    $uniqueIdentifier = [
                        'subnavigation_id' => $subnavigationId,
                        'menu_key' => $menuKey,
                    ];

                    if (array_key_exists("link01_$menuKey", $params) && $params["link01_$menuKey"] || array_key_exists("link02_$menuKey", $params) && $params["link02_$menuKey"]) {
                        SubnavigationSmartphoneMenu::updateOrCreate($uniqueIdentifier, [
                            'site_id' => $navigation->site_id,
                            'subnavigation_id' => $subnavigationId,
                            'link_type' => $params["link_type_$menuKey"],
                            'link01' => $params["link01_$menuKey"],
                            'link02' => $params["link02_$menuKey"],
                            'url' => $params["url_$menuKey"],
                            'media' => $params["media_$menuKey"],
                            'text' => $params["text_$menuKey"],
                        ]);
                    } else {
                        SubnavigationSmartphoneMenu::where($uniqueIdentifier)->delete();
                    }
                }

                return true;
            });

        } catch (\Exception $e) {
            Log::error("Stack trace: " . $e->getTraceAsString());
            return false;
        }
    }

    public function list($params) {
        $model = Subnavigation::query();

        return $model->paginate($params['per_page'] ?? self::DEFAULT_PER_PAGE);
    }

    public function deleteAll($ids)
    {
        return Subnavigation::whereIn('id', $ids)->delete();
    }
}
