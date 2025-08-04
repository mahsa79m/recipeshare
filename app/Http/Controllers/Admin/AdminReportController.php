<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
/**
 * مدیریت گزارش‌های پنل ادمین
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
                         ->latest()
                         ->paginate(20);  //  ۲۰ گزارش در هر صفحه

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
        $report->delete();

        return redirect()->route('admin.reports.index')
                         ->with('success', 'گزارش با موفقیت حذف شد.');
    }
}
