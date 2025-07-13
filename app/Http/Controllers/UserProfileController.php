<?php

namespace App\Http\Controllers;

use App\Models\User; // <-- این را اضافه کنید
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function show(User $user)
    {
        // با استفاده از Route Model Binding، لاراول کاربر را خودکار پیدا می‌کند

        // دستورهای غذایی تایید شده این کاربر را بارگذاری می‌کنیم
        $recipes = $user->recipes()
                        ->where('is_active', true)
                        ->latest()
                        ->get();

        return view('users.show', [
            'user' => $user,
            'recipes' => $recipes
        ]);
    }
}