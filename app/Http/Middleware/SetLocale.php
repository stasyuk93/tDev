<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Language;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $locale = Language::where('slug',$request->segment(1))->firstOrFail();
        app()->setLocale($locale->slug);
        return $next($request);
    }
}
