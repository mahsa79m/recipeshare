<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

/**
 * مدیریت نظرات
 *
 * کنترلر برای مشاهده، بازیابی و حذف دائمی نظرات در پنل ادمین.
 */
class CommentManagementController extends Controller
{
    /**
     * نمایش لیست تمام نظرات (شامل حذف شده‌ها)
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
       // دریافت تمام نظرات، شامل آنهایی که سافت دلیت شده‌اند
        $comments = Comment::withTrashed()
            ->with('user', 'recipe') // لود کردن روابط کاربر و دستور غذا
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
