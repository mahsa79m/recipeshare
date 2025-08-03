<x-app-layout>

    <x-slot name="header">
    </x-slot>
    <style>[x-cloak] { display: none !important; }</style>

    <div dir="rtl"
         x-data="{
             tab: new URLSearchParams(window.location.search).get('tab') || 'recipes',
             modalOpen: false,
             modalImageUrl: ''
         }"
         @open-modal.window="modalOpen = true; modalImageUrl = $event.detail.imageUrl">

        {{-- بخش هدر پروفایل --}}
        <div class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex flex-col md:flex-row items-center">

                    {{-- عکس پروفایل --}}
                    <button type="button" @click="modalOpen = true; modalImageUrl = '{{ $user->profile_image_path ? asset('storage/' . $user->profile_image_path) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&size=512' }}'" class="flex-shrink-0 focus:outline-none">
                        <img class="h-24 w-24 md:h-32 md:w-32 rounded-full object-cover border-4 border-amber-500 cursor-pointer transition-transform hover:scale-105"
                             src="{{ $user->profile_image_path ? asset('storage/' . $user->profile_image_path) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random&color=fff&size=128' }}"
                             alt="{{ $user->name }}">
                    </button>

                    <div class="md:mr-8 mt-4 md:mt-0 flex-1 text-center md:text-right">
                        <h1 class="text-3xl font-bold text-gray-800">{{ $user->name }}</h1>

                        <div class="flex justify-center md:justify-start space-x-6 space-x-reverse mt-4 text-gray-600">
                            <button @click="tab = 'recipes'" class="text-center focus:outline-none hover:text-amber-600 transition-colors">
                                <span class="font-bold text-lg">{{ $recipes->total() }}</span>
                                <span class="text-sm block">دستور پخت</span>
                            </button>
                            <button @click="tab = 'followers'" class="text-center focus:outline-none hover:text-amber-600 transition-colors">
                                <span class="font-bold text-lg">{{ $followersCount }}</span>
                                <span class="text-sm block">دنبال‌کننده</span>
                            </button>
                            <button @click="tab = 'followings'" class="text-center focus:outline-none hover:text-amber-600 transition-colors">
                                <span class="font-bold text-lg">{{ $followingsCount }}</span>
                                <span class="text-sm block">دنبال‌شونده</span>
                            </button>
                        </div>
                    </div>

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

        {{-- منوی زبانه‌ها --}}
        <div class="bg-white border-t">
            <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mb-px flex space-x-6 space-x-reverse" aria-label="Tabs">
                <button @click="tab = 'recipes'" :class="{ 'border-amber-500 text-amber-600': tab === 'recipes', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'recipes' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    دستورها
                </button>
                <button @click="tab = 'followers'" :class="{ 'border-amber-500 text-amber-600': tab === 'followers', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'followers' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    دنبال‌کنندگان
                </button>
                <button @click="tab = 'followings'" :class="{ 'border-amber-500 text-amber-600': tab === 'followings', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'followings' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    دنبال‌شوندگان
                </button>
            </nav>
        </div>

        {{-- محتوای زبانه‌ها --}}
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div x-show="tab === 'recipes'" x-cloak>
                    @if($recipes->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                            @foreach ($recipes as $recipe)
                                <div class="bg-white rounded-lg shadow-md overflow-hidden transform hover:-translate-y-2 transition duration-300 group">
                                    <a href="{{ route('recipes.show', $recipe) }}">

                                        <div class="aspect-square relative">
                                            <img src="{{ $recipe->image_path ? asset('storage/' . $recipe->image_path) : 'https://placehold.co/400x300/f97316/ffffff?text=Dastoor+Pokht' }}" alt="{{ $recipe->title }}" class="w-full h-full object-cover">
                                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-opacity duration-300"></div>
                                        </div>
                                        <div class="p-4">
                                            <h3 class="font-bold text-lg mb-2 truncate">{{ $recipe->title }}</h3>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-8">{{ $recipes->appends(['tab' => 'recipes'])->links() }}</div>
                    @else
                        <div class="text-center py-12"><p class="text-lg text-gray-500">{{ $user->name }} هنوز هیچ دستور پختی منتشر نکرده است.</p></div>
                    @endif
                </div>

                <div x-show="tab === 'followers'" x-cloak>
                    @include('users.partials._follow_list', ['users' => $followers, 'followingIds' => $followingIdsOnPage])
                </div>

                <div x-show="tab === 'followings'" x-cloak>
                    @include('users.partials._follow_list', ['users' => $followings, 'followingIds' => $followingIdsOnPage])
                </div>
            </div>
        </div>

        <div x-show="modalOpen" x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-center justify-center p-4">

            <div @click="modalOpen = false" class="absolute inset-0 bg-black bg-opacity-75"></div>

            <div @click.away="modalOpen = false"
                 x-show="modalOpen"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform scale-90"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 transform scale-100"
                 x-transition:leave-end="opacity-0 transform scale-90"
                 class="relative bg-white rounded-lg shadow-xl max-w-lg w-full">

                <img :src="modalImageUrl" alt="Profile Image" class="w-full h-auto object-contain rounded-t-lg max-h-[80vh]">
                <button @click="modalOpen = false" class="absolute top-2 left-2 p-2 bg-gray-800 bg-opacity-50 text-white rounded-full hover:bg-opacity-75">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>
    </div>
</x-app-layout>
