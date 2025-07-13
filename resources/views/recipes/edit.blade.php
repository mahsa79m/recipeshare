<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            ویرایش دستور غذا: {{ $recipe->title }} 📝
        </h2>
    </x-slot>

    <div dir="rtl" class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl border border-gray-200">
                <div class="p-8">
                    {{-- 1. تغییر action فرم و اضافه کردن متد PUT --}}
                    <form method="POST" action="{{ route('recipes.update', $recipe) }}" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="title" class="block text-right text-sm font-medium text-gray-700">عنوان دستور غذا</label>
                            {{-- 2. پر کردن فیلد با اطلاعات موجود --}}
                            <input type="text" name="title" id="title" value="{{ old('title', $recipe->title) }}"
                                   class="mt-1 block w-full text-right border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500"
                                   required>
                            @error('title')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="category_id" class="block text-right text-sm font-medium text-gray-700">دسته‌بندی</label>
                            <select name="category_id" id="category_id"
                                    class="mt-1 block w-full text-right border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500">
                                @foreach ($categories as $category)
                                    {{-- 2. انتخاب دسته‌بندی فعلی --}}
                                    <option value="{{ $category->id }}" {{ old('category_id', $recipe->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                             <label for="image_path" class="block text-right text-sm font-medium text-gray-700">تغییر تصویر اصلی غذا</label>
                             {{-- 3. نمایش تصویر فعلی --}}
                             <div class="mt-2">
                                 <img src="{{ asset('storage/' . $recipe->image_path) }}" alt="{{ $recipe->title }}" class="w-48 h-auto rounded-md">
                                 <p class="text-xs text-gray-500 mt-1">تصویر فعلی</p>
                             </div>
                             <input type="file" name="image_path" id="image_path"
                                    class="mt-4 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                                           file:rounded-full file:border-0 file:text-sm file:font-semibold
                                           file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
                             <p class="mt-1 text-xs text-gray-500">فقط در صورتی که قصد تغییر تصویر را دارید، فایل جدید انتخاب کنید.</p>
                             @error('image_path')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="ingredients" class="block text-right text-sm font-medium text-gray-700">مواد لازم</label>
                            {{-- 2. پر کردن فیلد با اطلاعات موجود --}}
                            <textarea name="ingredients" id="ingredients" rows="6"
                                      class="mt-1 block w-full text-right border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500">{{ old('ingredients', $recipe->ingredients) }}</textarea>
                             @error('ingredients')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-right text-sm font-medium text-gray-700">طرز تهیه</label>
                             {{-- 2. پر کردن فیلد با اطلاعات موجود --}}
                            <textarea name="description" id="description" rows="10"
                                      class="mt-1 block w-full text-right border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500">{{ old('description', $recipe->description) }}</textarea>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-start pt-4">
                             {{-- 4. تغییر متن دکمه --}}
                            <button type="submit"
                                    class="inline-flex items-center px-8 py-3 bg-amber-500 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-amber-600 active:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                ذخیره تغییرات
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>