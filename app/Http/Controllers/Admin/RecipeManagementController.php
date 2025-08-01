<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RecipeManagementController extends Controller
{
    public function index(Request $request)
    {
        // START: FIX - Calculate pending count and pass it to the view
        $pendingRecipesCount = Recipe::where('is_active', false)->count();
        // END: FIX

        $query = Recipe::with('user', 'category')->latest();

        // Filtering based on status
        if ($request->query('status') === 'pending') {
            $query->where('is_active', false);
        } elseif ($request->query('status') === 'published') {
            $query->where('is_active', true);
        }

        $recipes = $query->paginate(15)->withQueryString();

        return view('admin.recipes.index', [
            'recipes' => $recipes,
            'pendingRecipes' => $pendingRecipesCount // Pass the count to the view
        ]);
    }

    public function approve(Recipe $recipe)
    {
        $recipe->update(['is_active' => true]);
        return back()->with('success', 'دستور غذا با موفقیت تایید و منتشر شد.');
    }

    public function reject(Recipe $recipe)
    {
        if ($recipe->image_path && Storage::disk('public')->exists($recipe->image_path)) {
            Storage::disk('public')->delete($recipe->image_path);
        }
        $recipe->delete();
        return back()->with('success', 'دستور غذا با موفقیت رد و حذف شد.');
    }

    // New method to delete any recipe
    public function destroy(Recipe $recipe)
    {
        if ($recipe->image_path && Storage::disk('public')->exists($recipe->image_path)) {
            Storage::disk('public')->delete($recipe->image_path);
        }
        $recipe->delete();
        return back()->with('success', 'دستور غذا با موفقیت حذف شد.');
    }
}
