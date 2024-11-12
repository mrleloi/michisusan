<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Page;
use App\Services\PagesService;
use Illuminate\Support\Facades\Log;

class PageController extends Controller
{
    protected $pagesService;
    protected $templatesService;

    public function __construct(
        PagesService $pagesService,
    ) {
        $this->pagesService = $pagesService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = [
            'pages' => $this->pagesService->getAll()
        ];
        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'title' => 'string',
            'with_seo_title' => 'nullable',
            'description' => 'nullable',
            'h1_text' => 'nullable',
            'navigation_name' => 'nullable',
            'directory' => 'nullable',
            'keywords' => 'nullable',
            'show_tag' => 'nullable',
            'show_common_footer' => 'nullable',
            'account' => 'nullable',
            'password' => 'nullable',
            'eye_catch' => 'nullable',
            'page_id' => 'nullable',
            'show_top_navi' => 'nullable',
            'show_side_navi' => 'nullable',
            'show_bottom_navi' => 'nullable',
            'show_category' => 'nullable',
            'show_related_page' => 'nullable',
            'show_related_tag' => 'nullable',
            'show_sitemap' => 'nullable',
            'show_common_side_navi' => 'nullable',
            'show_seo_analysis' => 'nullable',
            'show_header' => 'nullable',
            'show_header_logo' => 'nullable',
            'show_header_navimenu' => 'nullable',
            'show_header_mv' => 'nullable',
            'show_footer' => 'nullable',
            'show_footer_logo' => 'nullable',
            'show_footer_navimenu' => 'nullable',
            'show_footer_sns' => 'nullable',
            'subnavagation_id' => 'nullable',
            'custom_css' => 'nullable',
            'custom_javascript' => 'nullable',
            'custom_head_tag' => 'nullable',
            'content' => 'nullable',
            'publish_status' => 'boolean|nullable',
        ]);
        $page = $this->pagesService->update($id, $data);
        return response()->json($page, 200);
    }

    public function updatePageIdByPages(Request $request)
    {
        $data = $request->validate([
            'pages' => 'array|nullable'
        ]);

        $updateChildren = function (int|null $parent_id, array $pages) {
            if (empty($pages)) {
                Page::find($parent_id)->update(['page_id' => null]);
            } else {
                Page::whereIn('id', array_column($pages, 'id'))->update(['page_id' => $parent_id]);
            }
        };

        foreach($data['pages'] as $p) {
            if (array_key_exists('children', $p)) {
                $children = $p['children'];
                foreach($children as $c) {
                    if (array_key_exists('children', $c)) {
                        $updateChildren($c['id'], $c['children']);
                        Log::debug('第3階層更新'.$c['id']);
                    }
                };
                $updateChildren($p['id'], $children);
                Log::debug('第2階層更新'.$p['id']);
            }
            $updateChildren($p['id'], []);
        }
        return response()->json('ok', 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $page = Page::find($id);
        $page->delete();
        return response()->json('ok', 204);
    }
}
