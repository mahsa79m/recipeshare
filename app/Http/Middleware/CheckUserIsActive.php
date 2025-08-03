<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // این خط برای دسترسی به مدل User ضروری است

class CheckUserIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next)
    {
        // ابتدا چک می‌کنیم که کاربری لاگین کرده باشد
        if (Auth::check()) {

            // کاربر را مستقیماً از دیتابیس می‌خوانیم تا از به‌روز بودن اطلاعات مطمئن شویم
            $freshUser = User::find(Auth::id());

            // اگر کاربر در دیتابیس وجود داشت ولی فعال نبود
            if ($freshUser && !$freshUser->is_active) {
                // فوراً او را از سیستم خارج می‌کنیم
                Auth::logout();

                // سشن فعلی را باطل می‌کنیم
                $request->session()->invalidate();

                // یک توکن جدید برای امنیت می‌سازیم
                $request->session()->regenerateToken();

                // کاربر را به صفحه لاگین با یک پیام خطا هدایت می‌کنیم
                return redirect()->route('login')->with('error', 'حساب کاربری شما توسط مدیر معلق شده است.');
            }
        }

        // اگر کاربر مشکلی نداشت، به او اجازه می‌دهیم به مسیرش ادامه دهد
        return $next($request);
    }
}
