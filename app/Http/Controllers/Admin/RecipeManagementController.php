<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * مدیریت دستورهای غذا
 *
 * کنترلر برای مشاهده، تایید، رد و حذف دستورهای غذای کاربران.
 */
class RecipeManagementController extends Controller
{
    /**
     * نمایش لیست دستورهای غذا
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // شمارش دستورهای غذای در انتظار تایید
         $pendingRecipesCount = Recipe::where('is_active', false)->count();

        $query = Recipe::with('user', 'category')->latest();

        // فیلترینگ بر اساس وضعیت
        if ($request->query('status') === 'pending') {
            $query->where('is_active', false);
        } elseif ($request->query('status') === 'published') {
            $query->where('is_active', true);
        }

        $recipes = $query->paginate(15)->withQueryString();

        return view('admin.recipes.index', [
            'recipes' => $recipes,
            'pendingRecipes' => $pendingRecipesCount
        ]);
    }

    /**
     * تایید و انتشار یک دستور غذا
     *
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve(Recipe $recipe)
    {
        $recipe->update(['is_active' => true]);
        return back()->with('success', 'دستور غذا با موفقیت تایید و منتشر شد.');
    }

    /**
     * رد و حذف یک دستور غذا
     *
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reject(Recipe $recipe)
    {
        // حذف عکس مرتبط از Storage و سپس حذف رکورد
        if ($recipe->image_path && Storage::disk('public')->exists($recipe->image_path)) {
            Storage::disk('public')->delete($recipe->image_path);
        }
        $recipe->delete();
        return back()->with('success', 'دستور غذا با موفقیت رد و حذف شد.');
    }

/**
     * حذف دائمی یک دستور غذا
     *
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Recipe $recipe)
    {
        if ($recipe->image_path && Storage::disk('public')->exists($recipe->image_path)) {
            Storage::disk('public')->delete($recipe->image_path);
        }
        $recipe->delete();
        return back()->with('success', 'دستور غذا با موفقیت حذف شد.');
    }
}
