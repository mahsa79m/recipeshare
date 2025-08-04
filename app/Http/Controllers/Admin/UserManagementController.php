<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * مدیریت کاربران
 */
class UserManagementController extends Controller
{
    /**
     * نمایش لیست همه کاربران
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
         //  به جز مدیر
        $users = User::where('id', '!=', Auth::id())
                     ->latest()
                     ->paginate(20);

        return view('admin.users.index', ['users' => $users]);
    }

    /**
     * فعال و غیرفعال کردن حساب کاربری
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleStatus(User $user)
    {
        $user->is_active = !$user->is_active;
        $user->save();

        $message = $user->is_active ? 'حساب کاربری با موفقیت فعال شد.' : 'حساب کاربری با موفقیت معلق شد.';

        return back()->with('success', $message);
    }
}
