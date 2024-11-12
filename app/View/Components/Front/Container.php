<?php

namespace App\View\Components\Front;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Site;
use App\Models\HeaderFooterSetting;
use App\Models\Page;


class Container extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public Site $site,
        public HeaderFooterSetting $headerFooterSetting,
        public $menu,
        public Page $page
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.front.container');
    }
}
