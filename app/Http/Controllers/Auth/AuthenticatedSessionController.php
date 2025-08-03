<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

/**
 * مدیریت نشست‌های احراز هویت
 *
 * کنترلر برای نمایش صفحه ورود، مدیریت فرآیند ورود و خروج کاربر.
 */
class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    /**
     * مدیریت درخواست احراز هویت ورودی
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $user = Auth::user();

        if (!$user->is_active) {

            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with('error', 'حساب کاربری شما توسط مدیر معلق شده است.');
        }

        $request->session()->regenerate();

        return redirect()->intended('/');
    }

    /**
     * از بین بردن نشست احراز هویت
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
