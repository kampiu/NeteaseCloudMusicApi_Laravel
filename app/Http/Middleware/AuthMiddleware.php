<?php
/**
 * Created by PhpStorm.
 * Author: Administrator
 * Date: 2019/5/16
 * Time: 10:22
 */

namespace App\Http\Middleware;

use App\Services\Api\AuthService;
use Closure;
use App\Exceptions\ApiException;

class AuthMiddleware
{

    private $authService;
    function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * 校验登录
     * User: hjt
     * Date Time: 2019/3/25 23:39
     */
    public function handle($request, Closure $next)
    {
        $notCheckRouter = [
            'login',
        ];
        $routeName = $request->route()->getName();
        $isLogin = true;
        if(!in_array($routeName,$notCheckRouter)){
            $isLogin = AuthService::userCheck();
        }
        if ($isLogin) {
            return $next($request);
        } else {
            throw new ApiException('请登录', 30405);
        }
    }
}