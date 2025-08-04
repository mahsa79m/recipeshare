<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Recipe;

/**
 *  داشبورد کاربر
 */
class HubController extends Controller
{
    /**
     * نمایش پروفایل و داشبورد اصلی کاربر.
     *
     * @return \Illuminate\View\View
     */
    public function showMyProfile()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $userIsActiveCondition = function ($query) {
            $query->where('is_active', true);
        };
        $recipesCount = $user->recipes()->where('is_active', true)->count();
        $followersCount = $user->followers()->count();
        $followingsCount = $user->followings()->count();

        $recipes = $user->recipes()
        ->where('is_active', true)
        ->latest()
        ->paginate(12, ['*'], 'recipes_page');

        $followers = $user->followers()
        ->where($userIsActiveCondition)
        ->paginate(21, ['*'], 'followers_page');

        $followings = $user->followings()
        ->where($userIsActiveCondition)
        ->paginate(21, ['*'], 'followings_page');

        $followingIdsOnPage = $user->followings()
        ->where($userIsActiveCondition)
        ->pluck('users.id');

        return view('dashboard', compact(
            'user',
            'recipesCount',
            'followersCount',
            'followingsCount',
            'recipes',
            'followers',
            'followings',
            'followingIdsOnPage'
        ));
    }
}
