<x-admin-layout>
    <h3 class="text-2xl font-medium text-gray-700">مدیریت کاربران</h3>

    <div class="mt-6">
        @if (session('success'))
            <div class="px-4 py-3 mb-4 text-white bg-green-500 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full">
                <thead>
                    <tr class="text-right text-xs font-medium tracking-wider text-gray-500 uppercase border-b">
                        <th class="px-6 py-3">نام</th>
                        <th class="px-6 py-3">ایمیل</th>
                        <th class="px-6 py-3">تاریخ عضویت</th>
                        <th class="px-6 py-3">وضعیت</th>
                        <th class="px-6 py-3">عملیات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($users as $user)
                        <tr class="text-sm text-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ verta($user->created_at)->format('Y/m/d') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($user->is_active)
                                    <span class="px-2 py-1 text-xs text-green-800 bg-green-200 rounded-full">فعال</span>
                                @else
                                    <span class="px-2 py-1 text-xs text-red-800 bg-red-200 rounded-full">معلق</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <form action="{{ route('admin.users.toggleStatus', $user) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-3 py-1 text-xs text-white rounded-md {{ $user->is_active ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }}">
                                        {{ $user->is_active ? 'معلق کردن' : 'فعال کردن' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</x-admin-layout>
