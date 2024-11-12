<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Services\PagesService;
use App\Services\TemplatesService;

class PageController extends Controller
{
    protected $pagesService;
    protected $templatesService;

    public function __construct(
        PagesService $pagesService,
        TemplatesService $templatesService,
    ) {
        $this->pagesService = $pagesService;
        $this->templatesService = $templatesService;
    }

    public function index(Request $request) {
        $pages = $this->pagesService->getAll();
        return view('pages.index', [
            'pages' => $pages
        ]);
    }

    public function templates(Request $request) {
        $per_page_choices = [
            ['label' => '10件表示', 'value' => 10],
            ['label' => '20件表示', 'value' => 20],
            ['label' => '50件表示', 'value' => 50],
            ['label' => '100件表示', 'value' => 100],
            ['label' => '200件表示', 'value' => 200]
        ];
        $limit = $request->get('per_page') ?? $per_page_choices[0]['value'];
        $templates = $this->templatesService->getTemplates($limit);
        return view('pages.templates', [
            'items' => $templates,
            'query' => ['per_page' => $per_page_choices],
            'limit' => $limit
        ]);
    }

    public function create_index(Request $request) {
        $pages = $this->pagesService->getAll();
        return view('pages.create', [
            'pages' => $pages
        ]);
    }

    public function create(Request $request) {
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
            'publish_status' => 'nullable',
        ]);
        $this->pagesService->create([
            'site_id' => 1,
            ...$data
        ]);
        return Redirect::route('pages.index');
    }

    public function edit(Request $request, string $id) {
        $page = $this->pagesService->findById($id);
        $pages = $this->pagesService->getAll();
        return view('pages.edit', [
            'page' => $page,
            'pages' => $pages
        ]);
    }


    public function update(Request $request, string $id) {
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
            'publish_status' => 'nullable',
        ]);
        $this->pagesService->update($id, $data);
        return Redirect::route('pages.edit', ['id' => $id])->with('success', '更新を完了しました');
    }

}
