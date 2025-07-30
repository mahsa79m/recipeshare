<x-app-layout>
    {{-- هدر پیش‌فرض خالی می‌ماند --}}
    <x-slot name="header"></x-slot>

    <div class="bg-slate-50" dir="rtl">

        <!-- هدر ثابت با ارتفاع کمتر -->
        <div class="sticky top-16 z-30 bg-white shadow-md">
             <div class="container mx-auto max-w-4xl px-4 flex items-center h-16">
                <h1 class="text-xl md:text-2xl font-bold text-gray-800 truncate">
                    {{ $recipe->title }}
                </h1>
            </div>
        </div>

        {{-- محتوای اصلی صفحه --}}
        <div class="container mx-auto max-w-4xl py-12 px-4 space-y-8">
            <div class="bg-white p-6 rounded-2xl shadow-lg">

                <!-- تصویر مربعی و کوچک‌تر -->
                @if ($recipe->image_path)
                    <div class="max-w-md mx-auto mb-8">
                        <div class="aspect-square w-full overflow-hidden rounded-2xl shadow-lg">
                            <img src="{{ asset('storage/' . $recipe->image_path) }}" alt="{{ $recipe->title }}" class="w-full h-full object-cover">
                        </div>
                    </div>
                @endif

                <!-- کارت نویسنده -->
                <div class="p-4 border rounded-2xl mb-8">
                    <a href="{{ route('users.show', $recipe->user) }}" class="flex items-center">
                        <img class="h-16 w-16 rounded-full object-cover border-2 border-amber-500"
                             src="{{ $recipe->user->profile_image_path ? asset('storage/' . $recipe->user->profile_image_path) : 'https://ui-avatars.com/api/?name=' . urlencode($recipe->user->name) }}"
                             alt="{{ $recipe->user->name }}">
                        <div class="mr-4">
                            <p class="text-sm text-gray-500">نویسنده</p>
                            <h4 class="font-bold text-lg text-gray-800 hover:text-amber-600">{{ $recipe->user->name }}</h4>
                        </div>
                    </a>
                </div>

                <!-- مواد لازم -->
                <div class="mb-8">
                    <h3 class="text-2xl font-bold mb-4 text-gray-800 border-b-2 border-amber-500 pb-2">مواد لازم</h3>
                    @php
                        $ingredientsList = json_decode($recipe->ingredients, true);
                        if (json_last_error() !== JSON_ERROR_NONE) { $ingredientsList = null; }
                    @endphp
                    @if(is_array($ingredientsList))
                        <ul class="list-disc list-inside space-y-2 prose prose-lg max-w-none text-gray-700">
                            @foreach($ingredientsList as $item)
                                <li><strong>{{ $item['name'] ?? '' }}</strong>: {{ $item['quantity'] ?? '' }} {{ $item['unit'] ?? '' }}</li>
                            @endforeach
                        </ul>
                    @else
                        <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed whitespace-pre-line">{{ $recipe->ingredients }}</div>
                    @endif
                </div>

                <!-- طرز تهیه -->
                <div>
                    <h3 class="text-2xl font-bold mb-4 text-gray-800 border-b-2 border-amber-500 pb-2">طرز تهیه</h3>
                    <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed whitespace-pre-line">
                        {{ $recipe->description }}
                    </div>
                </div>

                <!-- دکمه‌های ویرایش و حذف -->
                @can('update', $recipe)
                    <div class="flex items-center space-x-2 space-x-reverse border-t mt-8 pt-6">
                        <a href="{{ route('recipes.edit', $recipe) }}" class="px-4 py-2 text-sm font-semibold text-white bg-blue-500 rounded-lg hover:bg-blue-600">ویرایش دستور</a>
                        <form method="POST" action="{{ route('recipes.destroy', $recipe) }}" onsubmit="return confirm('آیا از حذف این دستور غذا مطمئن هستید؟')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-red-500 rounded-lg hover:bg-red-600">حذف دستور</button>
                        </form>
                    </div>
                @endcan
            </div>

            <!-- بخش نظرات و امتیازات -->
            <div class="bg-white p-6 rounded-2xl shadow-lg">
                <h3 class="text-2xl font-bold mb-4 text-gray-800">امتیاز و نظرات</h3>
                <div class="flex items-center mb-6">
                    <x-star-rating :rating="$averageRating" class="text-3xl" />
                    @if($ratingsCount > 0)
                        <span class="text-base text-gray-600 mr-2">میانگین <b>{{ number_format($averageRating, 1) }}</b> از <b>{{ $ratingsCount }}</b> رأی</span>
                    @else
                        <span class="text-base text-gray-600 mr-2">هنوز امتیازی ثبت نشده</span>
                    @endif
                </div>

                {{-- فرم‌های ثبت نظر و امتیاز --}}
                @auth
                    <div class="border-t pt-6">
                         <form action="{{ route('ratings.store', $recipe) }}" method="POST" class="mb-6">
                            @csrf
                            <h4 class="text-lg font-semibold mb-2">امتیاز شما</h4>
                            <div class="rating flex flex-row-reverse justify-end text-4xl">
                                <input type="radio" id="star5" name="rating" value="5" class="hidden" /><label for="star5" class="cursor-pointer text-gray-300 transition-colors">★</label>
                                <input type="radio" id="star4" name="rating" value="4" class="hidden" /><label for="star4" class="cursor-pointer text-gray-300 transition-colors">★</label>
                                <input type="radio" id="star3" name="rating" value="3" class="hidden" /><label for="star3" class="cursor-pointer text-gray-300 transition-colors">★</label>
                                <input type="radio" id="star2" name="rating" value="2" class="hidden" /><label for="star2" class="cursor-pointer text-gray-300 transition-colors">★</label>
                                <input type="radio" id="star1" name="rating" value="1" class="hidden" /><label for="star1" class="cursor-pointer text-gray-300 transition-colors">★</label>
                            </div>
                            <style>
                                .rating input:checked ~ label,
                                .rating label:hover,
                                .rating label:hover ~ label {
                                    color: #facc15;
                                }
                            </style>
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
                    @forelse ($recipe->comments->sortByDesc('created_at') as $comment)
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
</x-app-layout>
