<?php

namespace App\Policies;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RecipePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Recipe $recipe): Response
    {
        // اگر دستور غذا فعال باشد، همه (حتی مهمانان) می‌توانند ببینند
        if ($recipe->is_active) {
            return Response::allow();
        }

        // اگر دستور فعال نیست، فقط صاحب دستور یا ادمین می‌تواند ببیند
        if ($user && ($user->id === $recipe->user_id || $user->is_admin)) {
            return Response::allow();
        }

        return Response::deny('شما اجازه مشاهده این دستور غذای غیرفعال را ندارید.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // هر کاربر لاگین کرده‌ای می‌تواند دستور غذا ایجاد کند
        return $user !== null;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Recipe $recipe): bool
    {
        // فقط صاحب دستور غذا یا ادمین می‌تواند آن را ویرایش کند
       return $user->id === $recipe->user_id || $user->is_admin;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Recipe $recipe): bool
    {
        // فقط صاحب دستور غذا یا ادمین می‌تواند آن را حذف کند
       return $user->id === $recipe->user_id || $user->is_admin;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Recipe $recipe): bool
    {
        // فقط ادمین می‌تواند بازیابی کند
        return $user->is_admin;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Recipe $recipe): bool
    {
        // فقط ادمین می‌تواند برای همیشه حذف کند
        return $user->is_admin;
    }
}
