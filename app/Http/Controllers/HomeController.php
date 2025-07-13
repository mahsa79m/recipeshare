<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * نمایش صفحه اصلی سایت.
     */
    public function index()
    {
        // دریافت دسته‌بندی‌ها برای نوار ناوبری
        $categories = Category::where('is_active', true)->get();

        // دریافت ۱۲ دستور غذای جدید و تایید شده برای نمایش در صفحه اصلی
        $latestRecipes = Recipe::with('user')
            ->where('is_active', true)
            ->latest() // مرتب‌سازی بر اساس جدیدترین
            ->take(12) // فقط ۱۲ تای اول
            ->get();

        // ارسال داده‌ها به View
        return view('welcome', [
            'categories' => $categories,
            'latestRecipes' => $latestRecipes,
        ]);
    }
}