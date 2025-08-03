<!-- resources/views/categories/show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight" dir="rtl">
            دستورهای غذایی در دسته‌بندی: <span class="text-brand-orange">{{ $category->name }}</span>
        </h2>
    </x-slot>

    <div dir="rtl" class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @forelse ($recipes as $recipe)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden transform hover:-translate-y-2 transition duration-300">
                        <a href="{{ route('recipes.show', $recipe) }}">
                            <img src="{{ $recipe->image_path ? asset('storage/' . $recipe->image_path) : 'https://placehold.co/400x300/F5F5F5/333333?text=No+Image' }}" alt="{{ $recipe->title }}" class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h3 class="font-bold text-lg mb-2 truncate">{{ $recipe->title }}</h3>
                                <p class="text-sm text-gray-600">
                                    توسط: <a href="{{ route('users.show', $recipe->user) }}" class="font-medium text-brand-orange hover:underline">{{ $recipe->user->name }}</a>
                                </p>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-lg text-gray-500">
                            در حال حاضر هیچ دستور غذایی در این دسته‌بندی وجود ندارد.
                        </p>
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
