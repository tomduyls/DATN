<?php

namespace App\Http\Middleware;

use App\Utilities\Constant;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdminLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        //Neu chua dang nhap: chuyen huong toi trang dang nhap
        if (Auth::guest()) {
            return redirect()->guest('admin/login');
        }

        //Neu dang nhap sai level: dang xuat va dang nhap lai
        if (Auth::user()->level != Constant::user_level_admin && Auth::user()->level != Constant::user_level_host) {
            Auth::logout();

            return redirect()->guest('admin/login');
        }
        return $next($request);
    }
}
