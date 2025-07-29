<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HubController extends Controller
{
    // این متد، صفحه اصلی داشبور (پروفایل من) را نمایش می‌دهد
    public function showMyProfile()
    {
        /** @var \App\Models\User $user */ // <-- این خط به ویرایشگر کد کمک می‌کند
        $user = Auth::user();

        $recipesCount = $user->recipes()->where('is_active', true)->count();
        $followersCount = $user->followers()->count();
        $followingsCount = $user->followings()->count();

        return view('dashboard', compact('user', 'recipesCount', 'followersCount', 'followingsCount'));
    }

    // این متد، صفحه "دستورهای من" را نمایش می‌دهد
    public function showMyRecipes()
    {
        /** @var \App\Models\User $user */ // <-- این خط به ویرایشگر کد کمک می‌کند
        $user = Auth::user();

        $recipes = $user->recipes()->latest()->paginate(12);
        return view('my-recipes', compact('recipes'));
    }
}
