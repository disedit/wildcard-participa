<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;

class InPerson
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
        $payload = JWTAuth::getPayload(JWTAuth::getToken())->toArray();
        $inPerson = (isset($payload['in_person'])) ? $payload['in_person'] : false;

        if($inPerson) $request->attributes->add(['in_person' => true]);

        return $next($request);
    }
}
