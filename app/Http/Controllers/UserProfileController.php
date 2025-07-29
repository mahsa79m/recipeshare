<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    /**
     * نمایش صفحه پروفایل عمومی یک کاربر.
     */
    public function show(User $user, Request $request) // <-- Request را به متد اضافه کردیم
    {
        // دستورهای غذایی تایید شده این کاربر را به همراه صفحه‌بندی بارگذاری می‌کنیم
        $recipes = $user->recipes()
                        ->where('is_active', true)
                        ->latest()
                        ->paginate(12);

        // شمارش تعداد دنبال‌کنندگان و دنبال‌شوندگان
        $followersCount = $user->followers()->count();
        $followingsCount = $user->followings()->count();

        // بررسی اینکه آیا کاربر لاگین کرده، این پروفایل را دنبال می‌کند یا خیر
        $isFollowing = false;
        if ($request->user()) { // <-- بررسی می‌کنیم که آیا کاربری لاگین کرده است
            /** @var \App\Models\User $currentUser */
            $currentUser = $request->user();
            $isFollowing = $currentUser->isFollowing($user);
        }

        // ارسال تمام داده‌ها به View
        return view('users.show', [
            'user' => $user,
            'recipes' => $recipes,
            'followersCount' => $followersCount,
            'followingsCount' => $followingsCount,
            'isFollowing' => $isFollowing,
        ]);
    }
}
