<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Recipe;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard with site statistics.
     */
    public function index()
    {
        // آمار کلی
        $totalUsers = User::where('role', 'user')->count();
        $totalRecipes = Recipe::where('is_active', true)->count();
        $pendingRecipes = Recipe::where('is_active', false)->count();

        // داده‌های نمودار رشد کاربران
        $userGrowthData = User::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        $chartLabels = $userGrowthData->pluck('date')->map(fn($date) => verta($date)->format('d F'));
        $chartData = $userGrowthData->pluck('count');

        // داده‌های محبوب‌ترین دستورها
        $popularRecipes = Recipe::with('user')
            ->withAvg('ratings', 'rating')
            ->where('is_active', true)
            ->orderByDesc('ratings_avg_rating')
            ->take(5)
            ->get();

        // داده‌های فعال‌ترین کاربران
        $activeUsers = User::withCount(['recipes' => fn($query) => $query->where('is_active', true)])
            ->where('role', 'user')
            ->orderByDesc('recipes_count')
            ->take(5)
            ->get();

        // داده‌های جدیدترین کاربران
        $latestUsers = User::where('role', 'user')->latest()->take(5)->get();

        // --- بخش جدید: دریافت محبوب‌ترین دسته‌بندی‌ها ---
        $popularCategories = Category::withCount(['recipes' => fn($query) => $query->where('is_active', true)])
            ->orderByDesc('recipes_count')
            ->take(5) // ۵ دسته‌بندی برتر
            ->get();

        // ارسال تمام داده‌ها به View
        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'totalRecipes' => $totalRecipes,
            'pendingRecipes' => $pendingRecipes,
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
            'popularRecipes' => $popularRecipes,
            'activeUsers' => $activeUsers,
            'latestUsers' => $latestUsers,
            'popularCategories' => $popularCategories,
        ]);
    }
}
