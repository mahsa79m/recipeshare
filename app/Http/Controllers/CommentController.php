<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * مدیریت نظرات
 */
class CommentController extends Controller
{
    /**
     * ذخیره یک نظر جدید یا پاسخ
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request, Recipe $recipe)
    {
        $request->validate([
            'body' => 'required|string|max:2000',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

         // ایجاد نظر جدید با استفاده از رابطه allComments
        $recipe->allComments()->create([
            'user_id' => Auth::id(),
            'body' => $request->body,
            'parent_id' => $request->parent_id,
        ]);
         // بررسی نوع درخواست
        if ($request->ajax()) {

            $recipe->load(['comments.user', 'comments.replies.user']);

            $commentsHtml = view('recipes.partials._comments_section', ['recipe' => $recipe])->render();

            return response()->json([
                'message' => 'نظر شما با موفقیت ثبت شد.',
                'commentsHtml' => $commentsHtml
            ]);
        }

        return back()->with('success', 'نظر شما با موفقیت ثبت شد.');
    }
}
