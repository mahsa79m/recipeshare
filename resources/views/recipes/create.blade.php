<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            ایجاد یک دستور غذای جدید 🍳
        </h2>
    </x-slot>

    {{-- اعمال راست‌چین‌سازی به کل محتوای صفحه --}}
    <div dir="rtl" class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl border border-gray-200">
                <div class="p-8">
                    {{-- برای آپلود فایل، حتماً این مشخصه به فرم اضافه شود --}}
                    <form method="POST" action="{{ route('recipes.store') }}" enctype="multipart/form-data" class="space-y-8">
                        @csrf

                        <div>
                            <label for="title" class="block text-right text-sm font-medium text-gray-700">عنوان دستور غذا</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}"
                                   class="mt-1 block w-full text-right border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500"
                                   required placeholder="مثلا: قورمه سبزی مجلسی">
                            @error('title')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="category_id" class="block text-right text-sm font-medium text-gray-700">دسته‌بندی</label>
                            <select name="category_id" id="category_id"
                                    class="mt-1 block w-full text-right border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                             <label for="image_path" class="block text-right text-sm font-medium text-gray-700">تصویر اصلی غذا</label>
                             <input type="file" name="image_path" id="image_path"
                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                                           file:rounded-full file:border-0 file:text-sm file:font-semibold
                                           file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
                             @error('image_path')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>


                        <div>
                            <label for="ingredients" class="block text-right text-sm font-medium text-gray-700">مواد لازم</label>
                            <textarea name="ingredients" id="ingredients" rows="6"
                                      class="mt-1 block w-full text-right border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500"
                                      placeholder="هر ماده را در یک خط جداگانه بنویسید...">{{ old('ingredients') }}</textarea>
                             @error('ingredients')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-right text-sm font-medium text-gray-700">طرز تهیه</label>
                            <textarea name="description" id="description" rows="10"
                                      class="mt-1 block w-full text-right border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500"
                                      placeholder="مراحل آماده‌سازی را به ترتیب توضیح دهید...">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-start pt-4">
                            <button type="submit"
                                    class="inline-flex items-center px-8 py-3 bg-amber-500 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-amber-600 active:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                ثبت دستور غذا
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>