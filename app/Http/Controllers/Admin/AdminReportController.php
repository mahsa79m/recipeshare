<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
/**
 * مدیریت گزارش‌های پنل ادمین
 *
 * کنترلر برای بررسی، حذف و مدیریت گزارش‌های کاربران.
 */
class AdminReportController extends Controller
{
    /**
     * نمایش لیست گزارش‌های در انتظار
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {

        $reports = Report::with(['user', 'recipe'])
                         ->where('status', 'pending') // فقط گزارش‌های در حال انتظار
                         ->latest() // بر اساس جدیدترین
                         ->paginate(20);  // صفحه‌بندی: ۲۰ گزارش در هر صفحه

        return view('admin.reports.index', compact('reports'));
    }

    /**
     *  نمایش جزئیات یک گزارش
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\View\View
     */
    public function show(Report $report)
    {
        // لود کردن روابط کاربر و دستور غذا برای نمایش جزئیات
        $report->load(['user', 'recipe']);

        return view('admin.reports.show', compact('report'));
    }

    /**
     * تغییر وضعیت گزارش به "بررسی شده"
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resolve(Report $report)
    {
        // به‌روزرسانی وضعیت گزارش در دیتابیس
        $report->update(['status' => 'resolved']);

        return redirect()->route('admin.reports.index')
                         ->with('success', 'گزارش با موفقیت به وضعیت "بررسی شده" تغییر یافت.');
    }

    /**
     *  حذف کامل یک گزارش
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Report $report)
    {
        // حذف رکورد گزارش از دیتابیس
        $report->delete();

        return redirect()->route('admin.reports.index')
                         ->with('success', 'گزارش با موفقیت حذف شد.');
    }
}
