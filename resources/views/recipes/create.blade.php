<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            ایجاد یک دستور غذای جدید 🍳
        </h2>
    </x-slot>

    <div dir="rtl" class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-200">
                <form method="POST" action="{{ route('recipes.store') }}" enctype="multipart/form-data" class="space-y-8">
                    @csrf

                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">عنوان دستور غذا <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500"
                               required placeholder="مثلا: قورمه سبزی مجلسی">
                        @error('title') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700">دسته‌بندی <span class="text-red-500">*</span></label>
                        <select name="category_id" id="category_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div x-data="{ imagePreviewUrl: null }">
                         <label for="image_path" class="block text-sm font-medium text-gray-700">تصویر اصلی غذا</label>
                         <input type="file" name="image_path" id="image_path" @change="imagePreviewUrl = URL.createObjectURL($event.target.files[0])" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
                         @error('image_path') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        <div x-show="imagePreviewUrl" class="mt-4" style="display: none;">
                            <p class="text-sm font-semibold mb-2 text-gray-700">پیش‌نمایش تصویر:</p>
                            <div class="aspect-w-16 aspect-h-9 rounded-lg overflow-hidden border">
                                <img :src="imagePreviewUrl" class="w-full h-full object-cover">
                            </div>
                        </div>
                    </div>

                    <div x-data='{ ingredients: [{ quantity: "", unit: "عدد", name: "" }] }'>
                        <label class="block text-sm font-medium text-gray-700">مواد لازم <span class="text-red-500">*</span></label>
                        <div class="mt-2 space-y-3">
                            <template x-for="(ingredient, index) in ingredients" :key="index">
                                <div class="flex items-center gap-2">
                                    <input type="text" :name="`ingredients[${index}][quantity]`" x-model="ingredient.quantity" placeholder="مقدار" class="w-1/4 border-gray-300 rounded-md shadow-sm">
                                    <select :name="`ingredients[${index}][unit]`" x-model="ingredient.unit" class="w-1/3 border-gray-300 rounded-md shadow-sm">
                                        <option>عدد</option>
                                        <option>فنجان</option>
                                        <option>قاشق غذاخوری</option>
                                        <option>قاشق چای‌خوری</option>
                                        <option>گرم</option>
                                        <option>کیلوگرم</option>
                                        <option>حبه</option>
                                        <option>به مقدار لازم</option>
                                    </select>
                                    <input type="text" :name="`ingredients[${index}][name]`" x-model="ingredient.name" placeholder="نام ماده (مثلا: پیاز)" class="flex-1 border-gray-300 rounded-md shadow-sm">
                                    <button type="button" @click="ingredients.splice(index, 1)" x-show="ingredients.length > 1" class="p-2 text-red-500 hover:bg-red-100 rounded-full">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </template>
                        </div>
                        <button type="button" @click="ingredients.push({ quantity: '', unit: 'عدد', name: '' })" class="mt-3 text-sm font-semibold text-amber-600 hover:text-amber-800">+ افزودن ماده جدید</button>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">طرز تهیه <span class="text-red-500">*</span></label>
                        <textarea name="description" id="description" rows="10" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500" placeholder="مراحل آماده‌سازی را به ترتیب توضیح دهید...">{{ old('description') }}</textarea>
                        @error('description') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-start items-center pt-4 gap-4">
                        <button type="submit" class="inline-flex items-center px-8 py-3 bg-amber-500 border border-transparent rounded-md font-semibold text-white hover:bg-amber-600 focus:outline-none">
                            ثبت دستور غذا
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
