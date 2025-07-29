    <x-hub-layout>
        <x-slot name="header">
            دستورهای من
        </x-slot>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @forelse ($recipes as $recipe)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <a href="{{ route('recipes.show', $recipe) }}">
                        <img src="{{ $recipe->image_path ? asset('storage/' . $recipe->image_path) : 'https://placehold.co/400x300/f97316/ffffff?text=Dastoor+Pokht' }}" alt="{{ $recipe->title }}" class="w-full h-48 object-cover">
                    </a>
                    <div class="p-4">
                        <h3 class="font-bold text-lg mb-2 truncate">{{ $recipe->title }}</h3>
                        <div class="text-xs {{ $recipe->is_active ? 'text-green-600' : 'text-amber-600' }}">
                            {{ $recipe->is_active ? 'منتشر شده' : 'در انتظار تایید' }}
                        </div>
                    </div>
                </div>
            @empty
                <p class="col-span-full text-center text-gray-500">شما هنوز هیچ دستوری منتشر نکرده‌اید.</p>
            @endforelse
        </div>
        <div class="mt-8">
            {{ $recipes->links() }}
        </div>
    </x-hub-layout>
