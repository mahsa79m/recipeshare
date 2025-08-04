<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Recipe;
use App\Models\User;
use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Verta;

/**
 * کنترلر داشبورد ادمین
 */
class DashboardController extends Controller
{
   /**
     * نمایش داشبورد با آمار سایت.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $totalUsers = User::where('role', 'user')->count();

        $totalRecipes = Recipe::where('is_active', true)->count();
        $pendingReports = Report::where('status', 'pending')->count();

       // داده‌های نمودار رشد کاربران (اول 7 روز بود بعد کردمش ۳۰ روز اخیر)
        $userGrowthData = User::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

            // تبدیل تاریخ‌ها به شمسی Verta
        $chartLabels = $userGrowthData->pluck('date')->map(fn($date) => verta($date)->format('d F'));
        $chartData = $userGrowthData->pluck('count');

         //  محبوب‌ترین دستورها (بر اساس میانگین امتیاز)
        $popularRecipes = Recipe::with('user')
            ->withAvg('ratings', 'rating')
            ->where('is_active', true)
            ->orderByDesc('ratings_avg_rating')
            ->take(5) // ۵ دستور
            ->get();


        //  فعال‌ترین کاربران (بر اساس تعداد دستورهای فعال)
        $activeUsers = User::withCount(['recipes' => fn($query) => $query->where('is_active', true)])
            ->where('role', 'user')
            ->orderByDesc('recipes_count')
            ->take(5) // ۵ کاربر
            ->get();


        $latestUsers = User::where('role', 'user')->latest()->take(5)->get();

        // محبوب‌ترین دسته‌بندی‌ها
        $popularCategories = Category::withCount(['recipes' => fn($query) => $query->where('is_active', true)])
            ->orderByDesc('recipes_count')
            ->take(5) // ۵ دسته‌بندی
            ->get();


        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'totalRecipes' => $totalRecipes,
            'pendingReports' => $pendingReports,
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
            'popularRecipes' => $popularRecipes,
            'activeUsers' => $activeUsers,
            'latestUsers' => $latestUsers,
            'popularCategories' => $popularCategories,
        ]);
    }
}
