<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecipeController; // اضافه کردم
use App\Http\Controllers\HomeController; // اضافه کردم
use App\Http\Controllers\UserProfileController; // اضافه کردم
use App\Http\Controllers\FollowController; // اضافه کردم
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::resource('recipes', RecipeController::class); // اضافه کردم
	Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
	
	Route::post('/users/{user}/follow', [FollowController::class, 'store'])->name('users.follow'); // اضافه کردم
    Route::delete('/users/{user}/unfollow', [FollowController::class, 'destroy'])->name('users.unfollow'); // اضافه کردم

});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/users/{user}', [UserProfileController::class, 'show'])->name('users.show');

require __DIR__.'/auth.php';
