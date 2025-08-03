<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
/**
 * میدل‌ور بررسی دسترسی ادمین
 * این میدل‌ور چک می‌کنه که کاربر لاگین کرده و نقش ادمین داره یا نه
 */
class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {

        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }
        abort(403, 'Unauthorized action.');
    }
}
