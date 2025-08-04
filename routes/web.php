<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\HubController;
use App\Http\Controllers\StaticPageController;
use App\Http\Controllers\ReportController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RecipeManagementController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\CategoryManagementController;
use App\Http\Controllers\Admin\CommentManagementController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Middleware\AdminMiddleware;

/*
|--------------------------------------------------------------------------
| مسیرهای عمومی و اصلی سایت
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/users/{user}', [UserProfileController::class, 'show'])->name('users.show');
Route::get('/users/{user}/followers', [UserProfileController::class, 'showFollowers'])->name('users.followers');
Route::get('/users/{user}/followings', [UserProfileController::class, 'showFollowings'])->name('users.followings');
Route::get('/about-us', [StaticPageController::class, 'about'])->name('pages.about');
Route::get('/contact-us', [StaticPageController::class, 'contact'])->name('pages.contact');
Route::get('/faq', [StaticPageController::class, 'faq'])->name('pages.faq');


/*
|--------------------------------------------------------------------------
| مسیرهای مربوط به دستورهای غذا (Recipes)
|--------------------------------------------------------------------------
*/
Route::controller(RecipeController::class)->group(function () {
    // مسیرهای عمومی
    Route::get('/recipes', 'index')->name('recipes.index');

    // مسیرهای نیازمند احراز هویت (لاگین)
    Route::middleware('auth')->group(function () {
        Route::get('/recipes/create', 'create')->name('recipes.create'); //  ساخت
        Route::post('/recipes', 'store')->name('recipes.store');           // ذخیره
        Route::get('/feed', 'feed')->name('recipes.feed');                 // فید کاربر
        Route::get('/recipes/{recipe}/edit', 'edit')->name('recipes.edit'); // فرم ویرایش
        Route::patch('/recipes/{recipe}', 'update')->name('recipes.update'); // به‌روزرسانی
        Route::delete('/recipes/{recipe}', 'destroy')->name('recipes.destroy'); // حذف
    });

    Route::get('/recipes/{recipe}', 'show')->name('recipes.show'); // نمایش یک دستور غذا
});


/*
|--------------------------------------------------------------------------
|  مسیرهایی که نیازمند احراز هویت
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [HubController::class, 'showMyProfile'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/recipes/{recipe}/report', [ReportController::class, 'store'])->name('recipes.report');

    Route::post('/users/{user}/follow', [FollowController::class, 'store'])->name('users.follow');
    Route::delete('/users/{user}/unfollow', [FollowController::class, 'destroy'])->name('users.unfollow');
    Route::post('/recipes/{recipe}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/recipes/{recipe}/ratings', [RatingController::class, 'store'])->name('ratings.store');
});


/*
|--------------------------------------------------------------------------
| پنل مدیریت
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // User Management
    Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/toggle-status', [UserManagementController::class, 'toggleStatus'])->name('users.toggleStatus');

    // Recipe Management
    Route::get('/recipes', [RecipeManagementController::class, 'index'])->name('recipes.index');
    Route::patch('/recipes/{recipe}/approve', [RecipeManagementController::class, 'approve'])->name('recipes.approve');
    Route::patch('/recipes/{recipe}/reject', [RecipeManagementController::class, 'reject'])->name('recipes.reject');
    Route::delete('/recipes/{recipe}', [RecipeManagementController::class, 'destroy'])->name('recipes.destroy');

    // Category Management
    Route::resource('categories', CategoryManagementController::class)->except(['show']);

    // Comment Management
    Route::get('/comments', [CommentManagementController::class, 'index'])->name('comments.index');
    Route::patch('/comments/{id}/restore', [CommentManagementController::class, 'restore'])->name('comments.restore');
    Route::delete('/comments/{id}/force-delete', [CommentManagementController::class, 'forceDelete'])->name('comments.forceDelete');

    // Report Management
    Route::get('reports', [AdminReportController::class, 'index'])->name('reports.index');
    Route::get('reports/{report}', [AdminReportController::class, 'show'])->name('reports.show');
    Route::put('reports/{report}/resolve', [AdminReportController::class, 'resolve'])->name('reports.resolve');
    Route::delete('reports/{report}', [AdminReportController::class, 'destroy'])->name('reports.destroy');
});

require __DIR__.'/auth.php';
