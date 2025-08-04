<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * نمایش صفحه اصلی
 */
class HomeController extends Controller
{
    /**
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
            ->take(8) // ۸ دستور آخر
            ->get();

        $popularRecipes = Recipe::with('user')
            ->where('is_active', true)
            ->whereHas('user', $userIsActiveCondition)
            ->withAvg('ratings', 'rating')
            ->orderByDesc('ratings_avg_rating')
            ->take(8) // ۸ دستور محبوب
            ->get();

        $viewData = [
            'categories' => $categories,
            'latestRecipes' => $latestRecipes,
            'popularRecipes' => $popularRecipes,
        ];

       //  فید فعالیت‌ها
        if (Auth::check()) {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            $followingIds = $user->followings()->pluck('users.id');
            $followedRecipes = collect();

            if ($followingIds->isNotEmpty()) {
                $followedRecipes = Recipe::whereIn('user_id', $followingIds)
                    ->where('is_active', true)
                     ->whereHas('user', $userIsActiveCondition)
                    ->with('user')
                    ->withAvg('ratings', 'rating')
                    ->latest()
                    ->take(4) //  ۴ دستور آخر از دنبال شوندگان
                    ->get();
            }

            $viewData['followedRecipes'] = $followedRecipes;
        }

        return view('welcome', $viewData);
    }
}
