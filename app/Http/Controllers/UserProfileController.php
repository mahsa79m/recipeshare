<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
/**
 * کنترلر پروفایل عمومی کاربر
 *
 *  اطلاعات پروفایل ی کاربر رو برای بقیه اوکی می‌کنم
 */
class UserProfileController extends Controller
{
    /**
     * نمایش صفحه پروفایل عمومی یک کاربر.
     *
     * @param  \App\Models\User  $user
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function show(User $user, Request $request)
    {
        // فقط دستورپخت‌های فعال خود کاربر را نمایش بده
        $recipes = $user->recipes()
            ->where('is_active', true) // فرض بر این است که دستورپخت‌ها هم وضعیت فعال/غیرفعال دارند
            ->latest()
            ->paginate(12, ['*'], 'recipes_page');

        // فقط فالوورهایی را نمایش بده که خودشان فعال هستند
        $followers = $user->followers()
            ->where('is_active', true) // اصلاح شد: به جای whereHas از where مستقیم استفاده می‌کنیم
            ->distinct()
            ->paginate(21, ['*'], 'followers_page');

        // فقط فالووینگ‌هایی را نمایش بده که خودشان فعال هستند
        $followings = $user->followings()
            ->where('is_active', true) // اصلاح شد
            ->distinct()
            ->paginate(21, ['*'], 'followings_page');

        /** @var \App\Models\User|null $currentUser */
        $currentUser = Auth::user();

        $followingIdsOnPage = collect();
        if ($currentUser) {
            $allVisibleUserIds = $followers->pluck('id')->merge($followings->pluck('id'))->unique();
            if ($allVisibleUserIds->isNotEmpty()) {
                $followingIdsOnPage = $currentUser->followings()
                    ->where('is_active', true) // اصلاح شد
                    ->whereIn('users.id', $allVisibleUserIds)
                    ->pluck('users.id');
            }
        }

        $isFollowing = $currentUser ? $currentUser->isFollowing($user) : false;

        return view('users.show', [
            'user' => $user,
            'recipes' => $recipes,
            'followers' => $followers,
            'followings' => $followings,
            'followersCount' => $followers->total(),
            'followingsCount' => $followings->total(),
            'isFollowing' => $isFollowing,
            'followingIdsOnPage' => $followingIdsOnPage,
        ]);
    }
}
