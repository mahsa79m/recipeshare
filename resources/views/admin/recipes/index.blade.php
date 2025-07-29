<x-admin-layout>
    <h3 class="text-2xl font-medium text-gray-700">مدیریت دستورهای غذا (در انتظار تایید)</h3>

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
                        <th class="px-6 py-3">عنوان دستور</th>
                        <th class="px-6 py-3">نویسنده</th>
                        <th class="px-6 py-3">دسته‌بندی</th>
                        <th class="px-6 py-3">تاریخ ارسال</th>
                        <th class="px-6 py-3">عملیات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($recipes as $recipe)
                        <tr class="text-sm text-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('recipes.show', $recipe) }}" target="_blank" class="hover:text-amber-600 hover:underline">
                                    {{ $recipe->title }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $recipe->user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $recipe->category->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ verta($recipe->created_at)->format('Y/m/d') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap flex space-x-2 space-x-reverse">
                                <!-- دکمه تایید -->
                                <form action="{{ route('admin.recipes.approve', $recipe) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-3 py-1 text-xs text-white bg-green-500 rounded-md hover:bg-green-600">تایید</button>
                                </form>
                                <!-- دکمه رد کردن (حذف) -->
                                <form action="{{ route('admin.recipes.reject', $recipe) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" onclick="return confirm('آیا از رد و حذف این دستور مطمئن هستید؟')" class="px-3 py-1 text-xs text-white bg-red-500 rounded-md hover:bg-red-600">رد کردن</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                در حال حاضر هیچ دستور غذایی در انتظار تایید وجود ندارد.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $recipes->links() }}
        </div>
    </div>
</x-admin-layout>
