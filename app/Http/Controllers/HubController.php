<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Recipe; // <-- این خط را اضافه کنید

class HubController extends Controller
{
    // این متد، صفحه اصلی داشبور (پروفایل من) را نمایش می‌دهد
    public function showMyProfile()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // آمار قبلی شما
        $recipesCount = $user->recipes()->where('is_active', true)->count();
        $followersCount = $user->followers()->count();
        $followingsCount = $user->followings()->count();

        // --- منطق جدید برای فید فعالیت‌ها ---
        // 1. گرفتن شناسه‌ی کاربرانی که دنبالشان می‌کنید
        $followingIds = $user->followings()->pluck('users.id');

        // 2. گرفتن آخرین ۱۰ دستور غذایی از این کاربران
        $feedRecipes = Recipe::whereIn('user_id', $followingIds)
            ->where('is_active', true)
            ->with('user') // بهینه‌سازی برای جلوگیری از کوئری اضافه
            ->latest()
            ->take(10)
            ->get();

        // ارسال تمام داده‌ها به ویو
        return view('dashboard', compact(
            'user',
            'recipesCount',
            'followersCount',
            'followingsCount',
            'feedRecipes' // <-- ارسال داده‌های فید به ویو
        ));
    }

    // این متد، صفحه "دستورهای من" را نمایش می‌دهد
    public function showMyRecipes()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $recipes = $user->recipes()->latest()->paginate(12);
        return view('my-recipes', compact('recipes'));
    }
}
