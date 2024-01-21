<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckUserStatus
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
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->status == 0) {

                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                Session::flash('error', 'Your account is waiting for approving');
                return redirect()->route('login');  // Chuyển hướng đến trang thông báo chờ phê duyệt
            } elseif ($user->status == 1) {
                Session::flash('success', 'Login Successfully');
                return $next($request); // Cho phép truy cập vào tuyến đường
            } elseif ($user->status == 2) {

                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                Session::flash('error', 'Your account is refused');
                return redirect()->route('login'); // Chuyển hướng đến trang đăng nhập
            } else {

                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                Session::flash('error', 'Your account is deleted');
                return redirect()->route('login'); // Chuyển hướng đến trang đăng nhập
            }
        }

        return redirect()->route('login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
    }
}
