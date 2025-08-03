<x-hub-layout>
    <x-slot name="header">
        داشبورد
    </x-slot>

    <div x-data="{
            openSection: null,
            modalOpen: false,
            modalImageUrl: ''
        }">

        {{-- کارت اصلی پروفایل کاربر --}}
        <div class="bg-white p-8 rounded-lg shadow-md">
            <div class="flex flex-col md:flex-row items-center">

                {{-- عکس پروفایل قابل کلیک --}}
                <button type="button" @click="modalOpen = true; modalImageUrl = '{{ $user->profile_image_path ? asset('storage/' . $user->profile_image_path) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&size=512' }}'" class="flex-shrink-0 focus:outline-none">
                    <img class="h-32 w-32 rounded-full object-cover border-4 border-amber-500 cursor-pointer transition-transform hover:scale-105"
                         src="{{ $user->profile_image_path ? asset('storage/' . $user->profile_image_path) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random&color=fff&size=128' }}"
                         alt="{{ $user->name }}">
                </button>

                <div class="md:mr-8 mt-4 md:mt-0 text-center md:text-right">
                    <h1 class="text-3xl font-bold text-gray-800">{{ $user->name }}</h1>

                    {{-- آمار قابل کلیک --}}
                    <div class="flex justify-center md:justify-start space-x-6 space-x-reverse mt-3 text-gray-600">
                        <button @click="openSection = (openSection === 'recipes' ? null : 'recipes')" class="text-center hover:text-amber-600 transition-colors">
                            <span class="font-bold text-lg">{{ $recipesCount }}</span>
                            <span class="text-sm block">دستور پخت</span>
                        </button>
                        <button @click="openSection = (openSection === 'followers' ? null : 'followers')" class="text-center hover:text-amber-600 transition-colors">
                            <span class="font-bold text-lg">{{ $followersCount }}</span>
                            <span class="text-sm block">دنبال‌کننده</span>
                        </button>
                        <button @click="openSection = (openSection === 'followings' ? null : 'followings')" class="text-center hover:text-amber-600 transition-colors">
                            <span class="font-bold text-lg">{{ $followingsCount }}</span>
                            <span class="text-sm block">دنبال‌شونده</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- محتوای بخش‌های بازشونده --}}
        <div class="mt-6">
            <!-- بخش دستورهای من -->
            <div x-show="openSection === 'recipes'" x-cloak x-transition>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">دستورهای من</h3>
                    @if($recipes->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
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
                        <div class="mt-8">{{ $recipes->links('pagination::tailwind') }}</div>
                    @else
                        <p class="text-center text-gray-500 py-8">شما هنوز هیچ دستوری منتشر نکرده‌اید.</p>
                    @endif
                </div>
            </div>

            <!-- بخش دنبال‌کنندگان -->
            <div x-show="openSection === 'followers'" x-cloak x-transition>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">دنبال‌کنندگان</h3>
                    @include('users.partials._follow_list', ['users' => $followers, 'followingIds' => $followingIdsOnPage])
                </div>
            </div>

            <!-- بخش دنبال‌شوندگان -->
            <div x-show="openSection === 'followings'" x-cloak x-transition>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">دنبال‌شوندگان</h3>
                    @include('users.partials._follow_list', ['users' => $followings, 'followingIds' => $followingIdsOnPage])
                </div>
            </div>
        </div>

        <!-- مودال نمایش عکس بزرگ -->
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
</x-hub-layout>
