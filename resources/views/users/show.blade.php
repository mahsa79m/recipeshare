<x-app-layout>
    <div dir="rtl">
        <div class="bg-white shadow-sm">
            <div class="container mx-auto px-4 py-8 text-center">
                {{-- <img src="..." alt="{{ $user->name }}" class="w-24 h-24 rounded-full mx-auto mb-4"> --}}
                <h1 class="text-3xl font-bold">{{ $user->name }}</h1>
                <p class="text-gray-600 mt-2">عضویت از {{ $user->created_at->diffForHumans() }}</p>
                {{-- دکمه Follow در مرحله بعد اینجا اضافه خواهد شد --}}
            </div>
        </div>

        <main class="container mx-auto px-4 py-12">
            <h2 class="text-2xl font-bold mb-8 text-right">دستورهای غذایی {{ $user->name }}</h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @forelse ($recipes as $recipe)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden transform hover:-translate-y-2 transition duration-300">
                        <a href="{{ route('recipes.show', $recipe) }}">
                            <img src="{{ $recipe->image_path ? asset('storage/' . $recipe->image_path) : 'https://placehold.co/400x300/F5F5F5/333333?text=No+Image' }}" alt="{{ $recipe->title }}" class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h3 class="font-bold text-lg mb-2 truncate">{{ $recipe->title }}</h3>
                                <p class="text-sm text-gray-600">{{ $recipe->category->name }}</p>
                            </div>
                        </a>
                    </div>
                @empty
                    <p class="text-gray-500 col-span-full text-center">این کاربر هنوز دستور غذایی منتشر نکرده است.</p>
                @endforelse
            </div>
        </main>
    </div>
</x-app-layout>