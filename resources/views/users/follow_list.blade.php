<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <div class="py-12" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="space-y-4">
                        @forelse ($users as $listUser)
                            <div class="flex items-center justify-between p-4 border rounded-lg hover:bg-gray-50">
                                <a href="{{ route('users.show', $listUser) }}" class="flex items-center space-x-4 space-x-reverse">
                                    <img class="h-12 w-12 rounded-full object-cover"
                                         src="{{ $listUser->profile_image_path ? asset('storage/' . $listUser->profile_image_path) : 'https://ui-avatars.com/api/?name=' . urlencode($listUser->name) }}"
                                         alt="{{ $listUser->name }}">
                                    <span class="font-semibold text-gray-800">{{ $listUser->name }}</span>
                                </a>

                                {{-- دکمه دنبال کردن/لغو دنبال کردن --}}
                                @auth
                                    @if(Auth::id() !== $listUser->id)
                                        @if(Auth::user()->isFollowing($listUser))
                                            <form action="{{ route('users.unfollow', $listUser) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-4 py-2 text-sm bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300">
                                                    لغو دنبال کردن
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('users.follow', $listUser) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="px-4 py-2 text-sm bg-amber-500 text-white font-semibold rounded-lg hover:bg-amber-600">
                                                    دنبال کردن
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                @endauth
                            </div>
                        @empty
                            <p class="text-center text-gray-500 py-8">لیست خالی است.</p>
                        @endforelse
                    </div>

                    {{-- لینک‌های صفحه‌بندی --}}
                    <div class="mt-8">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
