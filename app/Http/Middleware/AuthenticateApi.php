<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Monolog\Handler\IFTTTHandler;


class AuthenticateApi
{
    const API_KEY_HEADER = 'x-api-key';
//    /**
//     * Handle an incoming request.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
//     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
//     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header(self::API_KEY_HEADER);

        if($token === null)
            return response(["message" => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);

        if ($token !== config('services.api.token')){
            return response(["message" => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }
        return $next($request);
    }
}
