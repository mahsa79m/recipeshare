<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Store a new report for a recipe.
     */
    public function store(Request $request, Recipe $recipe)
    {
        $request->validate([
            'reason' => 'required|string|in:spam,inappropriate,copyright',
            'details' => 'nullable|string|max:1000',
        ]);

        // جلوگیری از گزارش تکراری
        $existingReport = $recipe->reports()
            ->where('user_id', Auth::id())
            ->exists();

        if ($existingReport) {
            // اگر درخواست AJAX باشد، پاسخ خطای JSON برگردان
            if ($request->ajax()) {
                return response()->json(['message' => 'شما قبلاً این دستور غذا را گزارش کرده‌اید.'], 422);
            }
            return back()->with('error', 'شما قبلاً این دستور غذا را گزارش کرده‌اید.');
        }

        $recipe->reports()->create([
            'user_id' => Auth::id(),
            'reason' => $request->reason,
            'details' => $request->details,
        ]);

        // اگر درخواست AJAX باشد، پاسخ موفقیت‌آمیز JSON برگردان
        if ($request->ajax()) {
            return response()->json(['message' => 'گزارش شما با موفقیت ثبت شد. از همکاری شما متشکریم.']);
        }

        return back()->with('success', 'گزارش شما با موفقیت ثبت شد. از همکاری شما متشکریم.');
    }
}
