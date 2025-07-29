<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        // دستورهای غذایی فعال مربوط به این دسته‌بندی را به همراه اطلاعات کاربر بارگذاری می‌کنیم
        $recipes = $category->recipes()
                            ->where('is_active', true)
                            ->with('user')
                            ->latest()
                            ->paginate(12); // صفحه بندی نتایج

        // ارسال داده‌ها به یک View جدید
        return view('categories.show', [
            'category' => $category,
            'recipes' => $recipes,
        ]);
    }
}
