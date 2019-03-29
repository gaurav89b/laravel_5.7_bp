<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Api\V1\Response\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticateAdmin
{
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $allowedUsers = [
            config('user_roles.super_admin_role_id'),
            config('user_roles.admin_role_id'),
            config('user_roles.org_admin_role_id'),
        ];
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized !!!!.', 401);
            } else {
                return redirect()->guest('login');
            }
        } else {
            //if (!Auth::check() || Auth::user()->fk_users_role != \Config::get('user_roles.admin_role_id')) {
            if (!Auth::check() || !in_array(Auth::user()->fk_users_role, $allowedUsers)) {
                return response('Unauthorized.', 401);
            }
        }
        return $next($request);
    }
    
}
