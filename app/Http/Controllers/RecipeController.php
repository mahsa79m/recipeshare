<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Recipe;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     * این متد برای پشتیبانی از جستجو و صفحه‌بندی به‌روز شده است.
     */
    public function index(Request $request)
    {
        $query = Recipe::query();

        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%')
                  ->orWhere('ingredients', 'like', '%' . $searchTerm . '%');
            });
        }

        $recipes = $query->where('is_active', true)
                         ->with('user', 'category')
                         ->latest()
                         ->paginate(12);

        return view('recipes.index', [
            'recipes' => $recipes,
            'searchTerm' => $request->search ?? null
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('recipes.create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'ingredients' => 'required|string',
            'description' => 'required|string',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->store('recipes', 'public');
            $validatedData['image_path'] = $path;
        }

        $validatedData['user_id'] = auth()->id();
        // دستورهای جدید به صورت پیش‌فرض غیرفعال هستند
        $validatedData['is_active'] = true; 

        Recipe::create($validatedData);

        return redirect()->route('dashboard')->with('success', 'دستور غذای شما با موفقیت ثبت شد و منتظر تایید مدیر است.');
    }

    /**
     * Display the specified resource.
     * [اصلاح شده] از Route Model Binding استفاده می‌کند
     */
    public function show(Recipe $recipe)
    {
        // اطمینان از اینکه فقط دستورهای فعال قابل مشاهده هستند (مگر اینکه کاربر ادمین باشد)
        if (!$recipe->is_active && (!auth()->check() || auth()->user()->role !== 'admin')) {
            abort(404);
        }

        $recipe->load('comments.user');
        return view('recipes.show', ['recipe' => $recipe]);
    }

    /**
     * Show the form for editing the specified resource.
     * [اصلاح شده] از Route Model Binding استفاده می‌کند
     */
    public function edit(Recipe $recipe)
    {
        $this->authorize('update', $recipe);

        $categories = Category::all();
        return view('recipes.edit', [
            'recipe' => $recipe,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     * [اصلاح شده] از Route Model Binding استفاده می‌کند
     */
    public function update(Request $request, Recipe $recipe)
    {
        $this->authorize('update', $recipe);

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'ingredients' => 'required|string',
            'description' => 'required|string',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image_path')) {
            // کد حذف عکس قدیمی باید اینجا اضافه شود
            $path = $request->file('image_path')->store('recipes', 'public');
            $validatedData['image_path'] = $path;
        }

        $recipe->update($validatedData);

        return redirect()->route('recipes.show', $recipe)->with('success', 'تغییرات با موفقیت ذخیره شد!');
    }

    /**
     * Remove the specified resource from storage.
     * [اصلاح شده] از Route Model Binding استفاده می‌کند
     */
    public function destroy(Recipe $recipe)
    {
        $this->authorize('delete', $recipe);

        // کد حذف فایل عکس از storage باید اینجا اضافه شود
        $recipe->delete();

        return redirect()->route('recipes.index')->with('success', 'دستور غذا با موفقیت حذف شد.');
    }
}
