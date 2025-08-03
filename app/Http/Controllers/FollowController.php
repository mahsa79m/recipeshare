<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
/**
 * مدیریت دنبال کردن کاربران
 *
 * کنترلر برای دنبال کردن (Follow) و لغو دنبال کردن (Unfollow) کاربران.
 */
class FollowController extends Controller
{
    /**
     * دنبال کردن یک کاربر.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(User $user)
    {
        // اضافه کردن کاربر به لیست دنبال‌شونده‌ها
        /** @var \App\Models\User $currentUser */
        auth()->user()->followings()->attach($user->id);

        return back()->with('success', 'شما اکنون ' . $user->name . ' را دنبال می‌کنید.');
    }

    /**
     * لغو دنبال کردن یک کاربر.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        // کاربر را از لیست دنبال‌شونده‌ها حذف می‌کنیم
         /** @var \App\Models\User $currentUser */
        auth()->user()->followings()->detach($user->id);

        return back()->with('success', 'شما دیگر ' . $user->name . ' را دنبال نمی‌کنید.');
    }
}
