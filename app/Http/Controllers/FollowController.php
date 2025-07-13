<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    /**
     * یک کاربر را دنبال می‌کند.
     */
    public function store(User $user)
    {
        // با استفاده از رابطه‌ای که در مدل User ساختیم، کاربر را به لیست دنبال‌شونده‌ها اضافه می‌کنیم
        auth()->user()->followings()->attach($user->id);

        return back()->with('success', 'شما اکنون ' . $user->name . ' را دنبال می‌کنید.');
    }

    /**
     * دنبال کردن یک کاربر را لغو می‌کند.
     */
    public function destroy(User $user)
    {
        // کاربر را از لیست دنبال‌شونده‌ها حذف می‌کنیم
        auth()->user()->followings()->detach($user->id);

        return back()->with('success', 'شما دیگر ' . $user->name . ' را دنبال نمی‌کنید.');
    }
}