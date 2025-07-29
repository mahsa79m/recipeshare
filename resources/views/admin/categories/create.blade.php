<x-admin-layout>
    <h3 class="text-2xl font-medium text-gray-700">ایجاد دسته‌بندی جدید</h3>

    <div class="mt-6">
        <div class="p-6 bg-white rounded-lg shadow">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label for="name" class="text-gray-700">نام دسته‌بندی</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-amber-500 focus:ring-amber-500">
                        @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="slug" class="text-gray-700">اسلاگ (Slug)</label>
                        <input id="slug" name="slug" type="text" value="{{ old('slug') }}" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-amber-500 focus:ring-amber-500">
                        <p class="text-xs text-gray-500 mt-1">اختیاری. اگر خالی بگذارید، به صورت خودکار از روی نام ساخته می‌شود. (مثال: cake-and-cookie)</p>
                        @error('slug') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="flex justify-end mt-6">
                    <button type="submit" class="px-6 py-2 bg-amber-500 text-white font-semibold rounded-lg hover:bg-amber-600">
                        ذخیره
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
