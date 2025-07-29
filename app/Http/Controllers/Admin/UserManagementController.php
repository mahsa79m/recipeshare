<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserManagementController extends Controller
{
    /**
     * Display a list of all users.
     */
    public function index()
    {
        // دریافت تمام کاربران به جز مدیر فعلی، و صفحه‌بندی نتایج
        $users = User::where('id', '!=', Auth::id())
                     ->latest()
                     ->paginate(20);

        return view('admin.users.index', ['users' => $users]);
    }

    /**
     * Toggle the active status of a user account.
     * (فعال/غیرفعال کردن حساب کاربری)
     */
    public function toggleStatus(User $user)
    {
        // تغییر وضعیت 'is_active'
        // اگر true بود false می‌شود و برعکس
        $user->is_active = !$user->is_active;
        $user->save();

        $message = $user->is_active ? 'حساب کاربری با موفقیت فعال شد.' : 'حساب کاربری با موفقیت معلق شد.';

        return back()->with('success', $message);
    }
}
