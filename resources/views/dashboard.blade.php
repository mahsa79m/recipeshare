    <x-hub-layout>
        <x-slot name="header">
            پروفایل من
        </x-slot>

        <div class="bg-white p-8 rounded-lg shadow-md">
            <div class="flex flex-col md:flex-row items-center">
                <img class="h-32 w-32 rounded-full object-cover border-4 border-amber-500"
                     src="{{ $user->profile_image_path ? asset('storage/' . $user->profile_image_path) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random&color=fff&size=128' }}"
                     alt="{{ $user->name }}">

                <div class="md:mr-8 mt-4 md:mt-0 text-center md:text-right">
                    <h1 class="text-3xl font-bold text-gray-800">{{ $user->name }}</h1>

                    <div class="flex justify-center md:justify-start space-x-6 space-x-reverse mt-3 text-gray-600">
                        <div class="text-center"><span class="font-bold text-lg">{{ $recipesCount }}</span><span class="text-sm"> دستور پخت</span></div>
                        <div class="text-center"><span class="font-bold text-lg">{{ $followersCount }}</span><span class="text-sm"> دنبال‌کننده</span></div>
                        <div class="text-center"><span class="font-bold text-lg">{{ $followingsCount }}</span><span class="text-sm"> دنبال‌شونده</span></div>
                    </div>
                </div>
            </div>
        </div>
    </x-hub-layout>
