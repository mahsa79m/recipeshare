<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

/**
 * مدیریت نظرات
 */
class CommentManagementController extends Controller
{
    /**
     * نمایش لیست تمام نظرات وحتی حذف شده‌ها
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {

        $comments = Comment::withTrashed()
            ->with('user', 'recipe')
            ->latest()
            ->paginate(20);

        return view('admin.comments.index', ['comments' => $comments]);
    }

    /**
     * بازیابی یک نظر حذف شده
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        // پیدا کردن و بازیابی نظر سافت دلیت شده
        $comment = Comment::onlyTrashed()->findOrFail($id);
        $comment->restore();

        return back()->with('success', 'نظر با موفقیت بازیابی شد.');
    }

    /**
     * حذف دائمی یک نظر
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDelete($id)
    {
        // پیدا کردن و حذف دائمی نظر سافت دلیت شده
        $comment = Comment::onlyTrashed()->findOrFail($id);
        $comment->forceDelete();

        return back()->with('success', 'نظر برای همیشه حذف شد.');
    }
}
