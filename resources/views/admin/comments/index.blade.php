<x-admin-layout>
    <h3 class="text-2xl font-medium text-gray-700">مدیریت نظرات</h3>

    <div class="mt-6">
        @if (session('success'))
            <div class="px-4 py-3 mb-4 text-white bg-green-500 rounded-lg">{{ session('success') }}</div>
        @endif

        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full">
                <thead>
                    <tr class="text-right text-xs font-medium tracking-wider text-gray-500 uppercase border-b">
                        <th class="px-6 py-3">متن نظر</th>
                        <th class="px-6 py-3">نویسنده</th>
                        <th class="px-6 py-3">برای دستورِ</th>
                        <th class="px-6 py-3">وضعیت</th>
                        <th class="px-6 py-3">عملیات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($comments as $comment)
                        <tr class="text-sm {{ $comment->trashed() ? 'bg-red-50 text-gray-400' : 'text-gray-700' }}">
                            <td class="px-6 py-4">{{ Str::limit($comment->body, 60) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $comment->user->name ?? '[کاربر حذف شده]' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{-- *** تغییر اصلی در این بخش است *** --}}
                                @if ($comment->recipe)
                                    <a href="{{ route('recipes.show', $comment->recipe) }}" target="_blank" class="hover:underline text-amber-600">
                                        {{ Str::limit($comment->recipe->title, 25) }}
                                    </a>
                                @else
                                    <span class="text-gray-400">[دستور حذف شده]</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($comment->trashed())
                                    <span class="px-2 py-1 text-xs text-red-800 bg-red-200 rounded-full">حذف شده</span>
                                @else
                                    <span class="px-2 py-1 text-xs text-green-800 bg-green-200 rounded-full">فعال</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap flex space-x-2 space-x-reverse">
                                @if ($comment->trashed())
                                    {{-- دکمه‌های بازیابی و حذف دائمی --}}
                                    <form action="{{ route('admin.comments.restore', $comment->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-3 py-1 text-xs text-white bg-green-500 rounded-md hover:bg-green-600">بازیابی</button>
                                    </form>
                                    <form action="{{ route('admin.comments.forceDelete', $comment->id) }}" method="POST" onsubmit="return confirm('آیا از حذف دائمی این نظر مطمئن هستید؟ این عمل غیرقابل بازگشت است.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 text-xs text-white bg-red-700 rounded-md hover:bg-red-800">حذف دائمی</button>
                                    </form>
                                @else
                                    {{-- دکمه حذف نرم --}}
                                    {{-- Note: The destroy route for admin is not created yet. This is a placeholder. --}}
                                    <form action="#" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 text-xs text-white bg-red-500 rounded-md hover:bg-red-600">حذف</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                هیچ نظری یافت نشد.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $comments->links() }}
        </div>
    </div>
</x-admin-layout>
