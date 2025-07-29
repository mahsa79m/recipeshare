<x-app-layout>
    {{-- هدر جدید و سفارشی --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $recipe->title }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50" dir="rtl">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">

                <div class="lg:col-span-2">
                    <div class="bg-white p-6 rounded-2xl shadow-lg">
                        @if ($recipe->image_path)
                            <div class="aspect-w-16 aspect-h-9 rounded-xl overflow-hidden mb-6">
                                <img src="{{ asset('storage/' . $recipe->image_path) }}" alt="{{ $recipe->title }}" class="w-full h-full object-cover">
                            </div>
                        @endif

                        <div class="mb-8">
                            <h3 class="text-2xl font-bold mb-4 text-gray-800 border-b-2 border-amber-500 pb-2">مواد لازم</h3>
                            <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed whitespace-pre-line">
                                {{ $recipe->ingredients }}
                            </div>
                        </div>

                        <div>
                            <h3 class="text-2xl font-bold mb-4 text-gray-800 border-b-2 border-amber-500 pb-2">طرز تهیه</h3>
                            <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed whitespace-pre-line">
                                {{ $recipe->description }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-8">
                    <div class="bg-white p-6 rounded-2xl shadow-lg text-center">
                        <a href="{{ route('users.show', $recipe->user) }}" class="inline-block">
                            <img class="h-24 w-24 rounded-full object-cover mx-auto border-4 border-amber-200"
                                 src="{{ $recipe->user->profile_image_path ? asset('storage/' . $recipe->user->profile_image_path) : 'https://ui-avatars.com/api/?name=' . urlencode($recipe->user->name) }}"
                                 alt="{{ $recipe->user->name }}">
                        </a>
                        <h4 class="mt-4 text-xl font-bold text-gray-800">
                            <a href="{{ route('users.show', $recipe->user) }}" class="hover:text-amber-600">{{ $recipe->user->name }}</a>
                        </h4>
                        <p class="text-sm text-gray-500">{{ $recipe->user->followers()->count() }} دنبال‌کننده</p>

                        @auth
                            @if(Auth::id() !== $recipe->user->id)
                                <div class="mt-4">
                                    @if ($isFollowing)
                                        <form action="{{ route('users.unfollow', $recipe->user) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full px-6 py-2 bg-slate-200 text-slate-700 font-semibold rounded-lg hover:bg-slate-300">
                                                لغو دنبال کردن
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('users.follow', $recipe->user) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="w-full px-6 py-2 bg-amber-500 text-white font-semibold rounded-lg hover:bg-amber-600">
                                                دنبال کردن
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @endif
                        @endauth
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-lg">
                        <h3 class="text-2xl font-bold mb-4 text-gray-800">امتیاز و نظرات</h3>
                        <div class="flex items-center mb-6">
                            <x-star-rating :rating="$averageRating" />
                            @if($ratingsCount > 0)
                                <span class="text-sm text-gray-500 mr-2">میانگین <b>{{ number_format($averageRating, 1) }}</b> از <b>{{ $ratingsCount }}</b> رأی</span>
                            @else
                                <span class="text-sm text-gray-500 mr-2">هنوز امتیازی ثبت نشده</span>
                            @endif
                        </div>

                        {{-- فرم‌های ثبت نظر و امتیاز --}}
                        @auth
                            <div class="border-t pt-6">
                                <form action="{{ route('ratings.store', $recipe) }}" method="POST" class="mb-6">
                                    @csrf
                                    <h4 class="text-lg font-semibold mb-2">امتیاز شما</h4>
                                    {{-- Star rating input from previous implementation --}}
                                    <button type="submit" class="px-4 py-2 mt-2 bg-amber-500 text-white text-sm font-semibold rounded-md hover:bg-amber-600">ثبت امتیاز</button>
                                </form>
                                <form action="{{ route('comments.store', $recipe) }}" method="POST">
                                    @csrf
                                    <h4 class="text-lg font-semibold mb-2">نظر شما</h4>
                                    <textarea name="body" rows="4" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500" placeholder="نظر خود را بنویسید...">{{ old('body') }}</textarea>
                                    <div class="mt-3">
                                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700">ارسال نظر</button>
                                    </div>
                                </form>
                            </div>
                        @else
                            <div class="text-center border-t pt-6">
                                <p class="text-gray-600">برای ثبت نظر و امتیاز، لطفاً <a href="{{ route('login') }}" class="font-bold text-amber-600 underline">وارد شوید</a>.</p>
                            </div>
                        @endauth

                        {{-- لیست نظرات --}}
                        <div class="mt-8 border-t pt-6 space-y-6">
                            @forelse ($recipe->comments as $comment)
                                <div class="flex space-x-4 space-x-reverse">
                                    <img src="{{ $comment->user->profile_image_path ? asset('storage/' . $comment->user->profile_image_path) : 'https://ui-avatars.com/api/?name='.urlencode($comment->user->name) }}" alt="{{ $comment->user->name }}" class="w-12 h-12 rounded-full">
                                    <div class="flex-1">
                                        <div class="flex justify-between items-center">
                                            <p class="font-semibold text-gray-800">{{ $comment->user->name }}</p>
                                            <span class="text-xs text-gray-500">{{ verta($comment->created_at)->formatDifference() }}</span>
                                        </div>
                                        <p class="text-gray-600 mt-1">{{ $comment->body }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-center">اولین نفری باشید که نظر می‌دهد!</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-slate-800 text-white mt-12">
        <div class="container mx-auto px-4 py-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center md:text-right">
                <div>
                    <h3 class="text-lg font-bold mb-4">دستور پخت من</h3>
                    <p class="text-sm text-slate-400">جامعه‌ای برای اشتراک‌گذاری و کشف دستورهای غذایی جدید.</p>
                </div>
                <div>
                    <h3 class="text-md font-semibold mb-4">لینک‌های سریع</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="text-slate-400 hover:text-white">درباره ما</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-white">تماس با ما</a></li>
                        <li><a href="{{ route('recipes.index') }}" class="text-slate-400 hover:text-white">تمام دستورها</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-md font-semibold mb-4">ما را دنبال کنید</h3>
                    <div class="flex justify-center md:justify-start space-x-4 space-x-reverse">
                        <a href="#" class="text-slate-400 hover:text-white">اینستاگرام</a>
                        <a href="#" class="text-slate-400 hover:text-white">تلگرام</a>
                    </div>
                </div>
            </div>
            <div class="border-t border-slate-700 mt-8 pt-6 text-center text-slate-500 text-xs">
                <p>&copy; {{ date('Y') }} دستور پخت من. تمام حقوق محفوظ است.</p>
            </div>
        </div>
    </footer>
</x-app-layout>
