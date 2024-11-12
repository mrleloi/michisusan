<?php

namespace App\Http\Controllers;

use App\Services\NavibarService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SidebarController extends Controller
{
    protected $navibarService;

    public function __construct(
        NavibarService $navibarService
    ) {
        $this->navibarService = $navibarService;
    }

    public function index(Request $request) {
        return view('navibar', [
            'banner' => $this->navibarService->findBySiteId(1),
            'pages' => $this->navibarService->getPages(1)
        ]);
    }

    public function update(Request $request) {
        $this->navibarService->update(1, $request->validate([
            'top_banner1_link_url' => 'nullable',
            'top_banner1_image' => 'nullable',
            'top_banner1_alt' => 'nullable',
            'top_banner2_link_url' => 'nullable',
            'top_banner2_image' => 'nullable',
            'top_banner2_alt' => 'nullable',
            'top_banner3_link_url' => 'nullable',
            'top_banner3_image' => 'nullable',
            'top_banner3_alt' => 'nullable',
            'top_banner4_link_url' => 'nullable',
            'top_banner4_image' => 'nullable',
            'top_banner4_alt' => 'nullable',
            'top_banner5_link_url' => 'nullable',
            'top_banner5_image' => 'nullable',
            'top_banner5_alt' => 'nullable',
            'top_banner6_link_url' => 'nullable',
            'top_banner6_image' => 'nullable',
            'top_banner6_alt' => 'nullable',
            'top_banner7_link_url' => 'nullable',
            'top_banner7_image' => 'nullable',
            'top_banner7_alt' => 'nullable',
            'top_banner8_link_url' => 'nullable',
            'top_banner8_image' => 'nullable',
            'top_banner8_alt' => 'nullable',
            'bottom_banner1_link_url' => 'nullable',
            'bottom_banner1_image' => 'nullable',
            'bottom_banner1_alt' => 'nullable',
            'bottom_banner2_link_url' => 'nullable',
            'bottom_banner2_image' => 'nullable',
            'bottom_banner2_alt' => 'nullable',
            'bottom_banner3_link_url' => 'nullable',
            'bottom_banner3_image' => 'nullable',
            'bottom_banner3_alt' => 'nullable',
            'bottom_banner4_link_url' => 'nullable',
            'bottom_banner4_image' => 'nullable',
            'bottom_banner4_alt' => 'nullable',
            'bottom_banner5_link_url' => 'nullable',
            'bottom_banner5_image' => 'nullable',
            'bottom_banner5_alt' => 'nullable',
            'bottom_banner6_link_url' => 'nullable',
            'bottom_banner6_image' => 'nullable',
            'bottom_banner6_alt' => 'nullable',
            'bottom_banner7_link_url' => 'nullable',
            'bottom_banner7_image' => 'nullable',
            'bottom_banner7_alt' => 'nullable',
            'bottom_banner8_link_url' => 'nullable',
            'bottom_banner8_image' => 'nullable',
            'bottom_banner8_alt' => 'nullable',
        ]));
        return Redirect::route('sidenavi.index');
    }
}
