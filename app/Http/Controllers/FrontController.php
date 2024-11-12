<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FrontService;

class FrontController extends Controller
{

    protected $service;

    public function __construct(
        FrontService $service
    ) {
        $this->service = $service;
    }


    public function index(Request $request, $path = '/')
    {
        $site = $this->service->getSiteSettings();
        $page = $this->service->getPage($path);
        $menu = $this->service->getMenu($page);
        $headerFooterSetting = $site->headerFooterSetting;
        # TODO: ページにサブナビゲーションが適用されていれば上書き
        return view('front.index', compact('site', 'page', 'menu', 'headerFooterSetting'));
    }

}
