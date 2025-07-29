<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RecipeManagementController extends Controller
{
    /**
     * Display a list of pending recipes for approval.
     */
    public function index()
    {
        // دریافت دستورهای غذایی که در انتظار تایید هستند (is_active = false)
        // به همراه اطلاعات کاربر و دسته‌بندی برای نمایش در جدول
        $pendingRecipes = Recipe::with('user', 'category')
                                ->where('is_active', false)
                                ->latest()
                                ->paginate(15);

        return view('admin.recipes.index', ['recipes' => $pendingRecipes]);
    }

    /**
     * Approve a pending recipe.
     * (تایید کردن یک دستور غذا)
     */
    public function approve(Recipe $recipe)
    {
        $recipe->is_active = true;
        $recipe->save();

        // می‌توانید در اینجا یک ایمیل یا نوتیفیکیشن برای کاربر ارسال کنید
        // Mail::to($recipe->user)->send(new RecipeApproved($recipe));

        return back()->with('success', 'دستور غذا با موفقیت تایید و منتشر شد.');
    }

    /**
     * Reject and delete a pending recipe.
     * (رد کردن و حذف یک دستور غذا)
     */
    public function reject(Recipe $recipe)
    {
        // قبل از حذف رکورد از دیتابیس، تصویر مرتبط با آن را نیز از حافظه پاک می‌کنیم
        if ($recipe->image_path && Storage::disk('public')->exists($recipe->image_path)) {
            Storage::disk('public')->delete($recipe->image_path);
        }

        $recipe->delete();

        // می‌توانید یک ایمیل یا نوتیفیکیشن برای کاربر ارسال کنید که چرا دستورش رد شده است
        // Mail::to($recipe->user)->send(new RecipeRejected($recipe));

        return back()->with('success', 'دستور غذا با موفقیت رد و حذف شد.');
    }
}
