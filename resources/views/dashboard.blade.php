<x-hub-layout>
    <x-slot name="header">
        داشبورد
    </x-slot>

    {{-- کارت پروفایل کاربر --}}
    <div class="bg-white p-8 rounded-lg shadow-md">
        <div class="flex flex-col md:flex-row items-center">
            <img class="h-32 w-32 rounded-full object-cover border-4 border-amber-500"
                 src="{{ $user->profile_image_path ? asset('storage/' . $user->profile_image_path) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random&color=fff&size=128' }}"
                 alt="{{ $user->name }}">

            <div class="md:mr-8 mt-4 md:mt-0 text-center md:text-right">
                <h1 class="text-3xl font-bold text-gray-800">{{ $user->name }}</h1>

                {{-- آمار کلیدی (با لینک‌های جدید) --}}
                <div class="flex justify-center md:justify-start space-x-6 space-x-reverse mt-3 text-gray-600">
                    <div class="text-center">
                        <span class="font-bold text-lg">{{ $recipesCount }}</span>
                        <span class="text-sm"> دستور پخت</span>
                    </div>
                    <a href="{{ route('users.followers', $user) }}" class="text-center hover:text-amber-600 transition-colors">
                        <span class="font-bold text-lg">{{ $followersCount }}</span>
                        <span class="text-sm"> دنبال‌کننده</span>
                    </a>
                    <a href="{{ route('users.followings', $user) }}" class="text-center hover:text-amber-600 transition-colors">
                        <span class="font-bold text-lg">{{ $followingsCount }}</span>
                        <span class="text-sm"> دنبال‌شونده</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- فید فعالیت‌ها --}}
    <div class="mt-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">آخرین دستورهای دنبال‌شوندگان</h2>

        <div class="space-y-4">
            @forelse($feedRecipes as $recipe)
                <div class="bg-white rounded-lg shadow-md overflow-hidden transition-shadow hover:shadow-xl">
                    <div class="p-4 flex items-center space-x-4 space-x-reverse">
                        <!-- تصویر دستور -->
                        <a href="{{ route('recipes.show', $recipe) }}" class="flex-shrink-0">
                            <img src="{{ $recipe->image_path ? asset('storage/' . $recipe->image_path) : 'https://ui-avatars.com/api/?name=' . urlencode($recipe->title) .'&size=96' }}"
                                 alt="{{ $recipe->title }}"
                                 class="w-24 h-24 object-cover rounded-md">
                        </a>
                        <!-- اطلاعات دستور -->
                        <div class="flex-1">
                            <a href="{{ route('recipes.show', $recipe) }}" class="text-lg font-semibold text-gray-800 hover:text-amber-600 line-clamp-2">{{ $recipe->title }}</a>
                            <p class="text-sm text-gray-500 mt-1">
                                توسط <a href="{{ route('users.show', $recipe->user) }}" class="font-semibold hover:underline">{{ $recipe->user->name }}</a>
                            </p>
                            <p class="text-xs text-gray-400 mt-2">{{ verta($recipe->created_at)->formatDifference() }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white p-8 rounded-lg shadow-md text-center">
                    <p class="text-gray-500">شما هنوز کسی را دنبال نمی‌کنید یا افرادی که دنبال می‌کنید، دستوری منتشر نکرده‌اند.</p>
                    <a href="{{ route('recipes.index') }}" class="mt-4 inline-block px-6 py-2 bg-amber-500 text-white font-semibold rounded-lg hover:bg-amber-600 transition-colors">
                        کشف دستورهای جدید
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</x-hub-layout>
