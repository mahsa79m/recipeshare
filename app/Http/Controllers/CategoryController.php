<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Http\Request;

/**
 * نمایش دسته‌بندی‌ها
 *
 * کنترلر برای نمایش دستورهای غذایی مرتبط با یک دسته‌بندی خاص.
 */
class CategoryController extends Controller
{
    /**
     * نمایش جزئیات یک دسته‌بندی و دستورهای مرتبط با آن.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\View\View
     */
    public function show(Category $category)
    {
        $userIsActiveCondition = function ($query) {
            $query->where('is_active', true);
        };

       // دریافت دستورهای غذایی فعال مربوط به این دسته‌بندی
        $recipes = $category->recipes()
                            ->where('is_active', true)
                            ->whereHas('user', $userIsActiveCondition)
                            ->with('user')
                            ->latest()
                            ->paginate(12); // در هر صفحه 12 دستور

        // ارسال داده‌ها به ویو
        return view('categories.show', [
            'category' => $category,
            'recipes' => $recipes,
        ]);
    }
}
