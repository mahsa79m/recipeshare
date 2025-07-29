<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the homepage with all necessary data for the new professional design.
     */
    public function index()
    {
        // دریافت تمام دسته‌بندی‌های فعال به همراه تعداد دستورهای داخلشان
        $categories = Category::where('is_active', true)
            ->withCount(['recipes' => function ($query) {
                $query->where('is_active', true);
            }])
            ->get();

        // دریافت ۸ دستور غذای جدید به همراه اطلاعات کاربر و امتیازات
        $latestRecipes = Recipe::with('user')
            ->where('is_active', true)
            ->withAvg('ratings', 'rating')
            ->withCount('ratings')
            ->latest()
            ->take(8)
            ->get();

        // دریافت ۸ دستور پرطرفدار (با بالاترین امتیاز) به همراه اطلاعات کاربر و امتیازات
        $popularRecipes = Recipe::with('user')
            ->where('is_active', true)
            ->withAvg('ratings', 'rating')
            ->withCount('ratings')
            ->orderByDesc('ratings_avg_rating')
            ->take(8)
            ->get();

        // ارسال تمام داده‌ها به View
        return view('welcome', [
            'categories' => $categories,
            'latestRecipes' => $latestRecipes,
            'popularRecipes' => $popularRecipes,
        ]);
    }
}
