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
        $maxVotes = config('participa.max_per_ip');
        $maxFailedLookUps = config('participa.max_failed_lookups');
        $inPerson = $request->has('in_person');

        if(Limit::exceeded($request, 'IDFailedLookUp', $maxFailedLookUps)) {
            return response()->json([
                'IpLimit' => ['Too many failed lookups']
            ], 422);
        }

        if(!$inPerson && Limit::exceeded($request, 'Vote', $maxVotes)) {
            return response()->json([
                'IpLimit' => ['Exceeded']
            ], 422);
        }

        return $next($request);
    }
}
