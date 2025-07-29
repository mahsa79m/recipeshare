<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentManagementController extends Controller
{
    /**
     * Display a listing of all comments, including soft-deleted ones.
     */
    public function index()
    {
        // با استفاده از withTrashed، ما تمام نظرات، حتی حذف شده‌ها را دریافت می‌کنیم
        $comments = Comment::withTrashed()
            ->with('user', 'recipe') // لود کردن اطلاعات کاربر و دستور غذا برای نمایش
            ->latest()
            ->paginate(20);

        return view('admin.comments.index', ['comments' => $comments]);
    }

    /**
     * Restore a soft-deleted comment.
     */
    public function restore($id)
    {
        // فقط نظرات حذف شده را پیدا کرده و بازیابی کن
        $comment = Comment::onlyTrashed()->findOrFail($id);
        $comment->restore();

        return back()->with('success', 'نظر با موفقیت بازیابی شد.');
    }

    /**
     * Permanently delete a comment.
     */
    public function forceDelete($id)
    {
        // فقط نظرات حذف شده را پیدا کرده و برای همیشه حذف کن
        $comment = Comment::onlyTrashed()->findOrFail($id);
        $comment->forceDelete();

        return back()->with('success', 'نظر برای همیشه حذف شد.');
    }
}
