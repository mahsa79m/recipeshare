<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * یک نظر جدید را برای یک دستور غذا ذخیره می‌کند.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Recipe $recipe)
    {
        // 1. اعتبارسنجی داده‌های ورودی از فرم
        // اطمینان حاصل می‌کنیم که متن نظر خالی نباشد
        $request->validate([
            'body' => 'required|string|max:2000',
        ]);

        // 2. ایجاد نظر جدید با استفاده از رابطه تعریف شده در مدل Recipe
        // این روش به صورت خودکار recipe_id را تنظیم می‌کند
        $recipe->comments()->create([
            'user_id' => Auth::id(), // شناسه کاربری که لاگین کرده است
            'body' => $request->body,
            // فیلد is_active به صورت پیش‌فرض در مایگریشن true است
        ]);

        // 3. بازگرداندن کاربر به صفحه قبلی (صفحه دستور غذا) به همراه یک پیام موفقیت
        return back()->with('success', 'نظر شما با موفقیت ثبت شد.');
    }
}
