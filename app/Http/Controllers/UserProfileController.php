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
    public function show(User $user, Request $request)
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
        if ($request->user()) {
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

    /**
     * نمایش لیست دنبال‌کنندگان یک کاربر.
     */
    public function showFollowers(User $user)
    {
        $followers = $user->followers()->paginate(20);
        $title = 'دنبال‌کنندگان ' . $user->name;

        return view('users.follow_list', [
            'users' => $followers,
            'title' => $title,
            'mainUser' => $user
        ]);
    }

    /**
     * نمایش لیست افرادی که یک کاربر دنبال می‌کند.
     */
    public function showFollowings(User $user)
    {
        $followings = $user->followings()->paginate(20);
        $title = 'دنبال‌شوندگان ' . $user->name;

        return view('users.follow_list', [
            'users' => $followings,
            'title' => $title,
            'mainUser' => $user
        ]);
    }
}
