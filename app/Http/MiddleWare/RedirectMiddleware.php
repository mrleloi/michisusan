<?php

namespace App\Http\MiddleWare;

use Carbon\Carbon;
use Closure;
use App\Models\SiteRedirectRecord;
use Illuminate\Http\Request;

class RedirectMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $path = $request->path();
        $redirect = SiteRedirectRecord::where('slug_source', $path)->first();

        if ($redirect) {
            $check_date = Carbon::now();
            $redirectStart = Carbon::parse($redirect->redirect_start);
            $redirectEnd = Carbon::parse($redirect->redirect_end);

            if ($redirect->status_code === SiteRedirectRecord::STATUS_CODE_302
                && $check_date->between($redirectStart, $redirectEnd)
            ) {
                return redirect($redirect->slug_target);
            }
        }

        return $next($request);
    }
}
