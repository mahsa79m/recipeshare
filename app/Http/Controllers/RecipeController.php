<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RecipeController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $query = Recipe::query()->where('is_active', true)
            ->whereHas('user', function ($q) {
                $q->where('is_active', true);
            })
            ->with('user', 'category')
            ->latest();

        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                    ->orWhere('description', 'like', '%' . $searchTerm . '%')
                    ->orWhere('ingredients', 'like', '%' . $searchTerm . '%');
            });
        }

        $recipes = $query->paginate(12);

        // اگر درخواست از نوع AJAX باشد (برای اسکرول بی‌نهایت)
        if ($request->ajax()) {
            $view = view('recipes.partials._recipe_cards', compact('recipes'))->render();
            return response()->json(['html' => $view, 'hasMorePages' => $recipes->hasMorePages()]);
        }

        return view('recipes.index', [
            'recipes' => $recipes,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Recipe::class);
        $categories = Category::all();
        return view('recipes.create', ['categories' => $categories]);
    }


    public function show(Recipe $recipe)
    {
        $this->authorize('view', $recipe);
        // ما نظرات اصلی را به همراه پاسخ‌هایشان (و کاربر هر پاسخ) بارگذاری می‌کنیم
        $recipe->load(['comments.user', 'comments.replies.user']);

        $averageRating = $recipe->ratings()->avg('rating');
        $ratingsCount = $recipe->ratings()->count();

        return view('recipes.show', [
            'recipe' => $recipe,
            'averageRating' => $averageRating,
            'ratingsCount' => $ratingsCount,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $this->authorize('create', Recipe::class);

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ingredients' => 'required|array',
            'ingredients.*.quantity' => 'nullable|string|max:50',
            'ingredients.*.unit' => 'required|string|max:50',
            'ingredients.*.name' => 'required|string|max:255',
        ]);

        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->store('recipes', 'public');
            $validatedData['image_path'] = $path;
        }

        $validatedData['user_id'] = Auth::id();

        // دستورها به صورت پیش‌فرض فعال منتشر میشن
        $validatedData['is_active'] = true;

        $validatedData['ingredients'] = json_encode($request->ingredients);

        Recipe::create($validatedData);

        return redirect()->route('recipes.index')->with('success', 'دستور غذای شما با موفقیت منتشر شد.');
    }

    /**
     * Show the form for editing the specified resource.
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
            if ($recipe->image_path && Storage::disk('public')->exists($recipe->image_path)) {
                Storage::disk('public')->delete($recipe->image_path);
            }
            $path = $request->file('image_path')->store('recipes', 'public');
            $validatedData['image_path'] = $path;
        }

        if (Auth::user()->is_admin) {
            if (isset($request->is_active)) {
                $validatedData['is_active'] = (bool)$request->is_active;
            }
        }

        $recipe->update($validatedData);

        return redirect()->route('recipes.show', $recipe)->with('success', 'تغییرات با موفقیت ذخیره شد!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recipe $recipe)
    {
        $this->authorize('delete', $recipe);

        if ($recipe->image_path && Storage::disk('public')->exists($recipe->image_path)) {
            Storage::disk('public')->delete($recipe->image_path);
        }

        $recipe->delete();

        return redirect()->route('recipes.index')->with('success', 'دستور غذا با موفقیت حذف شد.');
    }

    public function feed(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $followingIds = $user->followings()->pluck('users.id');

        if ($followingIds->isEmpty()) {
            $recipes = Recipe::where('id', -1)->paginate(12); // Return an empty paginator
        } else {
            $query = Recipe::whereIn('user_id', $followingIds)
                ->where('is_active', true)
                ->with('user', 'category')
                ->latest();

            $recipes = $query->paginate(12);
        }

        // اگر درخواست از نوع AJAX باشد (برای اسکرول بی‌نهایت)
        if ($request->ajax()) {
            $view = view('recipes.partials._recipe_cards', compact('recipes'))->render();
            return response()->json(['html' => $view, 'hasMorePages' => $recipes->hasMorePages()]);
        }

        return view('recipes.feed', [
            'recipes' => $recipes,
        ]);
    }
}
