<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    /**
     * امتیاز یک کاربر برای یک دستور غذا را ثبت یا به‌روزرسانی می‌کند.
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

        // اگر درخواست از نوع AJAX باشد، پاسخ JSON به همراه داده‌های جدید برگردان
        if ($request->ajax()) {
            // محاسبه مجدد آمار پس از ثبت امتیاز
            $newAverageRating = $recipe->ratings()->avg('rating');
            $newRatingsCount = $recipe->ratings()->count();

            return response()->json([
                'message' => 'امتیاز شما با موفقیت ثبت شد.',
                'averageRating' => number_format($newAverageRating, 1),
                'ratingsCount' => $newRatingsCount,
            ]);
        }

        return back()->with('success', 'امتیاز شما با موفقیت ثبت و به‌روز شد.');
    }
}
