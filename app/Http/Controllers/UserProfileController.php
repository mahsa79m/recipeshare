<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
/**
 * کنترلر پروفایل کاربر
 *
 */
class UserProfileController extends Controller
{
    /**
     * نمایش صفحه کاربر.
     *
     * @param  \App\Models\User  $user
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function show(User $user, Request $request)
    {

        $recipes = $user->recipes()
            ->where('is_active', true)
            ->latest()
            ->paginate(12, ['*'], 'recipes_page');

        $followers = $user->followers()
            ->where('is_active', true)
            ->distinct()
            ->paginate(21, ['*'], 'followers_page');


        $followings = $user->followings()
            ->where('is_active', true)
            ->distinct()
            ->paginate(21, ['*'], 'followings_page');

        /** @var \App\Models\User|null $currentUser */
        $currentUser = Auth::user();

        $followingIdsOnPage = collect();
        if ($currentUser) {
            $allVisibleUserIds = $followers->pluck('id')->merge($followings->pluck('id'))->unique();
            if ($allVisibleUserIds->isNotEmpty()) {
                $followingIdsOnPage = $currentUser->followings()
                    ->where('is_active', true)
                    ->whereIn('users.id', $allVisibleUserIds)
                    ->pluck('users.id');
            }
        }

        $isFollowing = $currentUser ? $currentUser->isFollowing($user) : false;

        return view('users.show', [
            'user' => $user,
            'recipes' => $recipes,
            'followers' => $followers,
            'followings' => $followings,
            'followersCount' => $followers->total(),
            'followingsCount' => $followings->total(),
            'isFollowing' => $isFollowing,
            'followingIdsOnPage' => $followingIdsOnPage,
        ]);
    }
}
