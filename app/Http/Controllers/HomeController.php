<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * نمایش صفحه اصلی
 *
 * کنترلر برای دریافت و آماده‌سازی داده‌های لازم برای نمایش در صفحه اصلی
 */
class HomeController extends Controller
{
    /**
     * نمایش صفحه اصلی با تمام داده‌های لازم.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $userIsActiveCondition = function ($query) {
            $query->where('is_active', true);
        };
        $categories = Category::where('is_active', true)
            ->withCount(['recipes' => fn ($query) => $query->where('is_active', true)])
            ->get();

        $latestRecipes = Recipe::with('user')
            ->where('is_active', true)
            ->whereHas('user', $userIsActiveCondition)
            ->withAvg('ratings', 'rating')
            ->latest()
            ->take(8) // نمایش ۸ دستور آخر
            ->get();

        $popularRecipes = Recipe::with('user')
            ->where('is_active', true)
            ->whereHas('user', $userIsActiveCondition)
            ->withAvg('ratings', 'rating')
            ->orderByDesc('ratings_avg_rating')
            ->take(8) // نمایش ۸ دستور محبوب
            ->get();

        $viewData = [
            'categories' => $categories,
            'latestRecipes' => $latestRecipes,
            'popularRecipes' => $popularRecipes,
        ];

       // منطق نمایش فید فعالیت‌ها برای کاربران وارد شده
        if (Auth::check()) {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            $followingIds = $user->followings()->pluck('users.id');
            // ایجاد کالکشن خالی برای جلوگیری از خطا
            $followedRecipes = collect();

            if ($followingIds->isNotEmpty()) {
                // دریافت دستورهای غذای دنبال‌شوندگان
                $followedRecipes = Recipe::whereIn('user_id', $followingIds)
                    ->where('is_active', true)
                     ->whereHas('user', $userIsActiveCondition)
                    ->with('user')
                    ->withAvg('ratings', 'rating')
                    ->latest()
                    ->take(4) // نمایش ۴ دستور آخر از دنبال شوندگان
                    ->get();
            }

            $viewData['followedRecipes'] = $followedRecipes;
        }

        return view('welcome', $viewData);
    }
}
