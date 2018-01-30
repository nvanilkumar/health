<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\UserService;

/**
 * To check the login user related session 
 */
class ApiAuthentication
{

    public function __construct(UserService $userService)
    {

        $this->userService = $userService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//        $status = $this->userService->apicheck();
//        if ($status) {
//            return response('Unauthorized.', 401);
//        }

        return $next($request);
    }

}
