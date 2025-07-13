<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center" dir="rtl">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{-- اگر جستجویی انجام شده، عنوان را تغییر بده --}}
                @if (request('search'))
                    نتایج جستجو برای: "{{ request('search') }}"
                @else
                    دستورهای غذایی
                @endif
            </h2>
            
            <a href="{{ route('recipes.create') }}" class="px-5 py-2 bg-amber-500 text-white font-semibold rounded-lg shadow-md hover:bg-amber-600">
                + ایجاد دستور جدید
            </a>
        </div>
    </x-slot>

    <div dir="rtl" class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- نمایش مجدد فرم جستجو --}}
            <div class="mb-8">
                <form action="{{ route('recipes.index') }}" method="GET">
                    <input type="text" name="search" placeholder="جستجوی دوباره..." 
                           value="{{ request('search') }}" 
                           class="w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500">
                </form>
            </div>

            {{-- گرید نمایش نتایج --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @forelse ($recipes as $recipe)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden transform hover:-translate-y-2 transition duration-300">
                        <a href="{{ route('recipes.show', $recipe) }}">
                            <img src="{{ $recipe->image_path ? asset('storage/' . $recipe->image_path) : 'https://placehold.co/400x300/F5F5F5/333333?text=No+Image' }}" alt="{{ $recipe->title }}" class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h3 class="font-bold text-lg mb-2 truncate">{{ $recipe->title }}</h3>
                                {{-- این بخش به طور کامل تغییر کرده است --}}
                                <p class="text-sm text-gray-600">
                                    توسط:
                                    <a href="{{ route('users.show', $recipe->user) }}" class="font-medium text-brand-orange hover:underline">
                                        {{ $recipe->user->name }}
                                    </a>
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    در دسته:
                                    <a href="{{ route('categories.show', $recipe->category) }}" class="hover:underline">
                                        {{ $recipe->category->name }}
                                    </a>
                                </p>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-lg text-gray-500">
                            متاسفانه هیچ نتیجه‌ای یافت نشد.
                        </p>
                        <a href="{{ route('recipes.index') }}" class="mt-4 inline-block text-brand-orange hover:underline">بازگشت به لیست کامل دستورها</a>
                    </div>
                @endforelse
            </div>
            
            {{-- لینک‌های صفحه‌بندی --}}
            <div class="mt-8">
                {{ $recipes->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
