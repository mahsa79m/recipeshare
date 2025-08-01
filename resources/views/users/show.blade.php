<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            پروفایل {{ $user->name }}
        </h2>
    </x-slot>

    <div dir="rtl">
        {{-- بخش هدر پروفایل --}}
        <div class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex flex-col md:flex-row items-center">
                    <img class="h-24 w-24 md:h-32 md:w-32 rounded-full object-cover border-4 border-amber-500"
                         src="{{ $user->profile_image_path ? asset('storage/' . $user->profile_image_path) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random&color=fff&size=128' }}"
                         alt="{{ $user->name }}">

                    <div class="md:mr-8 mt-4 md:mt-0 flex-1 text-center md:text-right">
                        <h1 class="text-3xl font-bold text-gray-800">{{ $user->name }}</h1>

                        <!-- آمار (با لینک به صفحات جداگانه) -->
                        <div class="flex justify-center md:justify-start space-x-6 space-x-reverse mt-4 text-gray-600">
                            <div class="text-center">
                                <span class="font-bold text-lg">{{ $recipes->total() }}</span>
                                <span class="text-sm block">دستور پخت</span>
                            </div>
                            <a href="{{ route('users.followers', $user) }}" class="text-center hover:text-amber-600 transition-colors">
                                <span class="font-bold text-lg">{{ $followersCount }}</span>
                                <span class="text-sm block">دنبال‌کننده</span>
                            </a>
                            <a href="{{ route('users.followings', $user) }}" class="text-center hover:text-amber-600 transition-colors">
                                <span class="font-bold text-lg">{{ $followingsCount }}</span>
                                <span class="text-sm block">دنبال‌شونده</span>
                            </a>
                        </div>
                    </div>

                    <!-- دکمه دنبال کردن یا ویرایش پروفایل -->
                    <div class="mt-4 md:mt-0">
                        @auth
                            @if (Auth::id() === $user->id)
                                <a href="{{ route('dashboard') }}" class="px-6 py-2 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300">
                                    ورود به پنل کاربری
                                </a>
                            @else
                                @if ($isFollowing)
                                    <form action="{{ route('users.unfollow', $user) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="px-6 py-2 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 w-32">
                                            دنبال می‌کنید
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('users.follow', $user) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-6 py-2 bg-amber-500 text-white font-semibold rounded-lg hover:bg-amber-600 w-32">
                                            دنبال کردن
                                        </button>
                                    </form>
                                @endif
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        {{-- گالری دستورهای غذا --}}
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">دستورهای پخت منتشر شده</h2>
                @if($recipes->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                        @foreach ($recipes as $recipe)
                            <div class="bg-white rounded-lg shadow-md overflow-hidden transform hover:-translate-y-2 transition duration-300">
                                <a href="{{ route('recipes.show', $recipe) }}">
                                    <img src="{{ $recipe->image_path ? asset('storage/' . $recipe->image_path) : 'https://placehold.co/400x300/f97316/ffffff?text=Dastoor+Pokht' }}" alt="{{ $recipe->title }}" class="w-full h-48 object-cover">
                                    <div class="p-4">
                                        <h3 class="font-bold text-lg mb-2 truncate">{{ $recipe->title }}</h3>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-8">{{ $recipes->links() }}</div>
                @else
                    <div class="text-center py-12"><p class="text-lg text-gray-500">{{ $user->name }} هنوز هیچ دستور پختی منتشر نکرده است.</p></div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
