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
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RecipeManagementController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\CategoryManagementController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\HubController;
use App\Http\Controllers\Admin\CommentManagementController;
/*
|--------------------------------------------------------------------------
| مسیرهای عمومی
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/users/{user}', [UserProfileController::class, 'show'])->name('users.show');

/*
|--------------------------------------------------------------------------
| مسیرهای نیازمند احراز هویت
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // مسیرهای جدید هاب کاربری
    Route::get('/dashboard', [HubController::class, 'showMyProfile'])->name('dashboard');
    Route::get('/my-recipes', [HubController::class, 'showMyRecipes'])->name('my-recipes');

    // مسیرهای استاندارد پروفایل
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //
    Route::get('/recipes/create', [RecipeController::class, 'create'])->name('recipes.create');
    Route::post('/recipes', [RecipeController::class, 'store'])->name('recipes.store');
    Route::get('/recipes/{recipe}/edit', [RecipeController::class, 'edit'])->name('recipes.edit');
    Route::patch('/recipes/{recipe}', [RecipeController::class, 'update'])->name('recipes.update');
    Route::delete('/recipes/{recipe}', [RecipeController::class, 'destroy'])->name('recipes.destroy');
    Route::post('/users/{user}/follow', [FollowController::class, 'store'])->name('users.follow');
    Route::delete('/users/{user}/unfollow', [FollowController::class, 'destroy'])->name('users.unfollow');
    Route::post('/recipes/{recipe}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/recipes/{recipe}/ratings', [RatingController::class, 'store'])->name('ratings.store');
});

/*
|--------------------------------------------------------------------------
| پنل مدیریت (فقط ادمین)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/toggle-status', [UserManagementController::class, 'toggleStatus'])->name('users.toggleStatus');
    Route::get('/recipes', [RecipeManagementController::class, 'index'])->name('recipes.index');
    Route::patch('/recipes/{recipe}/approve', [RecipeManagementController::class, 'approve'])->name('recipes.approve');
    Route::patch('/recipes/{recipe}/reject', [RecipeManagementController::class, 'reject'])->name('recipes.reject');
    Route::resource('categories', CategoryManagementController::class)->except(['show']);

    Route::get('/comments', [CommentManagementController::class, 'index'])->name('comments.index');
    Route::patch('/comments/{id}/restore', [CommentManagementController::class, 'restore'])->name('comments.restore');
    Route::delete('/comments/{id}/force-delete', [CommentManagementController::class, 'forceDelete'])->name('comments.forceDelete');

});

Route::get('/recipes/{recipe}', [RecipeController::class, 'show'])->name('recipes.show');

require __DIR__.'/auth.php';
