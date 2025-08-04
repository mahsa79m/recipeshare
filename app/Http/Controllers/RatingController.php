<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * کنترلر امتیازدهی
 */
class RatingController extends Controller
{
    /**
     * ثبت یا به‌روزرسانی امتیاز یک دستور غذا
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request, Recipe $recipe)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $recipe->ratings()->updateOrCreate(
            ['user_id' => Auth::id()],
            ['rating' => $request->rating]
        );


        if ($request->ajax()) {
            $recipe->load('ratings');

            $newAverageRating = $recipe->ratings()->avg('rating');
            $newRatingsCount = $recipe->ratings()->count();

            return response()->json([
                'message' => 'امتیاز شما با موفقیت ثبت شد.',
                'averageRating' => (float) $newAverageRating,
                'ratingsCount' => (int) $newRatingsCount,
            ]);
        }

        return back()->with('success', 'امتیاز شما با موفقیت ثبت و به‌روز شد.');
    }
}
