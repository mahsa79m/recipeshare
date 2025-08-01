<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * یک نظر جدید یا پاسخ را برای یک دستور غذا ذخیره می‌کند.
     */
    public function store(Request $request, Recipe $recipe)
    {
        $request->validate([
            'body' => 'required|string|max:2000',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $recipe->allComments()->create([ // از رابطه allComments برای ثبت استفاده می‌کنیم
            'user_id' => Auth::id(),
            'body' => $request->body,
            'parent_id' => $request->parent_id,
        ]);

        // اگر درخواست از نوع AJAX باشد، بخش نظرات را دوباره رندر کرده و برگردان
        if ($request->ajax()) {
            // بارگذاری مجدد دستور غذا با تمام نظرات و پاسخ‌های به‌روز شده
            $recipe->load(['comments.user', 'comments.replies.user']);

            // رندر کردن بخش نظرات به صورت یک partial view
            $commentsHtml = view('recipes.partials._comments_section', ['recipe' => $recipe])->render();

            return response()->json([
                'message' => 'نظر شما با موفقیت ثبت شد.',
                'commentsHtml' => $commentsHtml
            ]);
        }

        return back()->with('success', 'نظر شما با موفقیت ثبت شد.');
    }
}
