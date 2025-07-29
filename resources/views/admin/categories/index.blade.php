<x-admin-layout>
    <div class="flex justify-between items-center">
        <h3 class="text-2xl font-medium text-gray-700">مدیریت دسته‌بندی‌ها</h3>
        <a href="{{ route('admin.categories.create') }}" class="px-4 py-2 bg-amber-500 text-white font-semibold rounded-lg hover:bg-amber-600">
            ایجاد دسته‌بندی جدید
        </a>
    </div>

    <div class="mt-6">
        @if (session('success'))
            <div class="px-4 py-3 mb-4 text-white bg-green-500 rounded-lg">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="px-4 py-3 mb-4 text-white bg-red-500 rounded-lg">{{ session('error') }}</div>
        @endif

        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full">
                <thead>
                    <tr class="text-right text-xs font-medium tracking-wider text-gray-500 uppercase border-b">
                        <th class="px-6 py-3">نام</th>
                        <th class="px-6 py-3">اسلاگ (Slug)</th>
                        <th class="px-6 py-3">تعداد دستورها</th>
                        <th class="px-6 py-3">عملیات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($categories as $category)
                        <tr class="text-sm text-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $category->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $category->slug }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $category->recipes()->count() }}</td>
                            <td class="px-6 py-4 whitespace-nowrap flex space-x-2 space-x-reverse">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="px-3 py-1 text-xs text-white bg-blue-500 rounded-md hover:bg-blue-600">ویرایش</a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('آیا از حذف این دسته‌بندی مطمئن هستید؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 text-xs text-white bg-red-500 rounded-md hover:bg-red-600">حذف</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                هیچ دسته‌بندی‌ای یافت نشد.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $categories->links() }}
        </div>
    </div>
</x-admin-layout>
