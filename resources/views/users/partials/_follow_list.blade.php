<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <div class="py-12" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($users as $listUser)
                    <div class="bg-white rounded-2xl shadow-md p-6 flex flex-col items-center text-center transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <a href="{{ route('users.show', $listUser) }}" class="flex flex-col items-center">
                            <img class="h-20 w-20 rounded-full object-cover border-4 border-slate-200"
                                 src="{{ $listUser->profile_image_path ? asset('storage/' . $listUser->profile_image_path) : 'https://ui-avatars.com/api/?name=' . urlencode($listUser->name) }}"
                                 alt="{{ $listUser->name }}">
                            <span class="mt-4 font-bold text-lg text-gray-800 hover:text-amber-600">{{ $listUser->name }}</span>
                        </a>

                        <div class="mt-4 w-full">
                            @auth
                                @if(Auth::id() !== $listUser->id)
                                    @if(Auth::user()->isFollowing($listUser))
                                        <form action="{{ route('users.unfollow', $listUser) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full px-4 py-2 text-sm bg-slate-200 text-slate-700 font-semibold rounded-lg hover:bg-slate-300 transition-colors">
                                                دنبال شده
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('users.follow', $listUser) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="w-full px-4 py-2 text-sm bg-amber-500 text-white font-semibold rounded-lg hover:bg-amber-600 transition-colors">
                                                دنبال کردن
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            @endauth
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-16 bg-white rounded-lg shadow-md">
                        <p class="text-lg text-gray-500">این لیست در حال حاضر خالی است.</p>
                    </div>
                @endforelse
            </div>

            @if ($users->hasPages())
                <div class="mt-8">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
