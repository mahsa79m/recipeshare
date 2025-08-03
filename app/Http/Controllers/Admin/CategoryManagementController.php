<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

 /**
     * مدیریت دسته‌بندی‌ها
     * کنترلر برای ایجاد، ویرایش، حذف و نمایش دسته‌بندی‌ها در پنل ادمین.
     */
class CategoryManagementController extends Controller
{
    /**
     * نمایش لیست دسته‌بندی‌ها
     *
     * @return \Illuminate\View\View
     */

    public function index()
    {
        $categories = Category::latest()->paginate(15);
        return view('admin.categories.index', ['categories' => $categories]);
    }

    /**
     * نمایش فرم ایجاد دسته‌بندی جدید
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * ذخیره دسته‌بندی جدید
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // اعتبارسنجی اطلاعات ورودی
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
        ]);

        // ایجاد Slug در صورت خالی بودن
        Category::create([
            'name' => $validated['name'],
            'slug' => $validated['slug'] ?? Str::slug($validated['name']),
            'is_active' => true,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'دسته‌بندی جدید با موفقیت ایجاد شد.');
    }

    /**
     * نمایش فرم ویرایش یک دسته‌بندی
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\View\View
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', ['category' => $category]);
    }

    /**
     * به‌روزرسانی دسته‌بندی
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('categories')->ignore($category->id)],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('categories')->ignore($category->id)],
        ]);

        $category->update([
            'name' => $validated['name'],
            'slug' => $validated['slug'] ?? Str::slug($validated['name']),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'دسته‌بندی با موفقیت به‌روزرسانی شد.');
    }

    /**
     * حذف یک دسته‌بندی
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Category $category)
    {
        // جلوگیری از حذف در صورت وجود دستور غذایی مرتبط
            if ($category->recipes()->count() > 0) {
            return back()->with('error', 'امکان حذف این دسته‌بندی وجود ندارد زیرا دستورهای غذایی به آن متصل هستند.');
        }

        // حذف دسته‌بندی از دیتابیس
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'دسته‌بندی با موفقیت حذف شد.');
    }
}
