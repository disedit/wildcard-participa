<?php

namespace App\Http\Middleware;

use Closure;
use App\Limit;

class IpLimit
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
        $max = config('participa.max_per_ip');
        $inPerson = $request->has('in_person');

        if(!$inPerson && Limit::exceeded($request, 'vote', $max)) {
            return response()->json([
                'Ip_Limit' => 'Exceeded'
            ]);
        }

        return $next($request);
    }
}
