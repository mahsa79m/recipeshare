<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
    */
    public function handle(Request $request, Closure $next): Response
    {
        // این میدل‌ور بررسی می‌کند که آیا کاربر لاگین کرده است یا نه
        // و آیا نقش (role) او 'admin' است یا خیر.
        // ما از Accessor که قبلا ساختیم ($user->is_admin) استفاده می‌کنیم.
        if (Auth::check() && Auth::user()->is_admin) {
            // اگر کاربر ادمین بود، به او اجازه عبور می‌دهیم.
            return $next($request);
        }

        // اگر کاربر ادمین نبود، با خطای 403 (عدم دسترسی) مواجه می‌شود.
        abort(403, 'Unauthorized action.');
    }
}
