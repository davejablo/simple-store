<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
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
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof TokenInvalidException){
                return response()->json([
                    'code' => 401,
                    'status' => 'Token is Invalid :Z',
                    'message' => 'Please provide valid token'
                ], 401);
            }else if ($e instanceof TokenExpiredException){
                return response()->json([
                    'code' => 401,
                    'status' => 'Token is Expired :C',
                    'message' => 'Please provide an existent token'
                ],401);
            }else{
                return response()->json([
                    'code' => 401,
                    'status' => 'Authorization Token not found :|',
                    'message' => 'Bearer Token is required'
                ],401);
            }
        }
        return $next($request);
    }
}
