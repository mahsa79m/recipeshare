<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

/**
 * تایید رمز عبور
 *
 * کنترلر برای تایید مجدد رمز عبور کاربر در عملیات حساس.
 */
class ConfirmablePasswordController extends Controller
{
    /**
     * نمایش صفحه تایید رمز عبور
     */
    public function show(): View
    {
        return view('auth.confirm-password');
    }

    /**
     *تایید رمز عبور کاربر
     */
    public function store(Request $request): RedirectResponse
    {
        if (! Auth::guard('web')->validate([
            'email' => $request->user()->email,
            'password' => $request->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        $request->session()->put('auth.password_confirmed_at', time());

        return redirect()->intended(route('dashboard', absolute: false));
    }
}
