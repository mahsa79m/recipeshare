<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    /**
     * امتیاز یک کاربر برای یک دستور غذا را ثبت یا به‌روزرسانی می‌کند.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Recipe $recipe)
    {
        // 1. اعتبارسنجی داده‌های ورودی
        // اطمینان حاصل می‌کنیم که امتیاز یک عدد صحیح بین 1 تا 5 باشد
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        // 2. استفاده از متد updateOrCreate برای ثبت یا به‌روزرسانی امتیاز
        // لاراول ابتدا به دنبال رکوردی با user_id و recipe_id مشخص شده می‌گردد.
        // - اگر پیدا کرد، فیلد rating آن را به‌روز می‌کند.
        // - اگر پیدا نکرد، یک رکورد جدید با تمام این اطلاعات ایجاد می‌کند.
        $recipe->ratings()->updateOrCreate(
            [
                'user_id' => Auth::id(), // شرط برای جستجو
            ],
            [
                'rating' => $request->rating, // مقداری که باید ثبت یا آپدیت شود
            ]
        );

        // 3. بازگرداندن کاربر به صفحه قبلی به همراه یک پیام موفقیت
        return back()->with('success', 'امتیاز شما با موفقیت ثبت و به‌روز شد.');
    }
}
