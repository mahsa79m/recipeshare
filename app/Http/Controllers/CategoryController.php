<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Http\Request;

/**
 * نمایش دسته‌بندی‌ها
 */
class CategoryController extends Controller
{
    /**
     * نمایش یک دسته‌بندی و دستورهای مرتبط
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\View\View
     */
    public function show(Category $category)
    {
        $userIsActiveCondition = function ($query) {
            $query->where('is_active', true);
        };


        $recipes = $category->recipes()
                            ->where('is_active', true)
                            ->whereHas('user', $userIsActiveCondition)
                            ->with('user')
                            ->latest()
                            ->paginate(12); // در هر صفحه 12 دستور

        return view('categories.show', [
            'category' => $category,
            'recipes' => $recipes,
        ]);
    }
}
