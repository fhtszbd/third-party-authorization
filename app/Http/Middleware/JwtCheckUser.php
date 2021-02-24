<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtCheckUser extends  BaseMiddleware
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
        //检查此次请求中是否带有token，如果没有抛出异常
        $header_token = $request->header('Authorization');
        if (!$header_token) {
            return response()->json(['data' => [], 'message' => 'token缺失', 'code' => 401],500);
        }
        try {
            if(!$user = JWTAuth::parseToken()->authenticate()){ //获取到用户数据并赋值给$user
                return response()->json(['data' => [], 'message' => '无该用户', 'code' => 502],500);
            }
            return $next($request);
        } catch (TokenExpiredException $e) {
            return response()->json(['data' => [], 'message' => 'token已过期', 'code' => 502],500);
        } catch (TokenInvalidException $e) {
            return response()->json(['data' => [], 'message' => 'token无效', 'code' => 502],500);
        } catch (JWTException $e) {
            throw new UnauthorizedHttpException('jwt-auth', $e->getMessage());
        } catch (\Exception $e) {
            return response()->json(['data' => [], 'message' => $e->getMessage(), 'code' => 502],500);
        }
    }
}
