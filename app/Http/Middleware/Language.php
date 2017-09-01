<?php

namespace App\Http\Middleware;

use App;
use Closure;

class Language
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
        $currentLanguage = (!$request->get('lang')) ? $request->cookie('language') : $request->get('lang');
        App::setLocale($currentLanguage);

        return $next($request);
    }
}
