<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="bg-slate-50" dir="rtl"
         x-data="{
             openReplyForm: null,
             successMessage: '',
             isLoading: false,
             avgRating: {{ (float)$averageRating ?? 0 }},
             ratingsCount: {{ $ratingsCount ?? 0 }},

             submitForm(event, type) {
                 event.preventDefault();
                 this.isLoading = true;
                 this.successMessage = '';
                 let form = event.target;
                 let formData = new FormData(form);

                 fetch(form.action, {
                     method: 'POST',
                     headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
                     body: formData
                 })
                 .then(response => response.json())
                 .then(data => {
                     this.successMessage = data.message;
                     if (type === 'rating') {
                         this.avgRating = data.averageRating;
                         this.ratingsCount = data.ratingsCount;
                     } else {
                         document.getElementById('comments-section').innerHTML = data.commentsHtml;
                         form.reset();
                         this.openReplyForm = null;
                     }
                     setTimeout(() => this.successMessage = '', 3000);
                 })
                 .catch(error => console.error('Error:', error))
                 .finally(() => this.isLoading = false);
             }
         }">

        <!-- اعلان Toast (منتقل شده به بالا) -->
        <div
            x-show="successMessage"
            x-cloak
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform -translate-y-4"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform -translate-y-4"
            class="fixed top-20 left-1/2 -translate-x-1/2 px-6 py-3 bg-green-500 text-white rounded-full shadow-lg z-50"
        >
            <p x-text="successMessage"></p>
        </div>

        <div class="container mx-auto max-w-4xl py-12 px-4 space-y-8">
            <div class="bg-white p-6 rounded-2xl shadow-lg">
                {{-- بخش بالایی صفحه (عنوان، عکس، نویسنده و ...) --}}
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6 text-center">
                    {{ $recipe->title }}
                </h1>

                @if ($recipe->image_path)
                    <div class="mb-8">
                        <div class="aspect-square w-full overflow-hidden rounded-2xl shadow-lg">
                            <img src="{{ asset('storage/' . $recipe->image_path) }}" alt="{{ $recipe->title }}" class="w-full h-full object-cover">
                        </div>
                    </div>
                @endif

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

                <div>
                    <h3 class="text-2xl font-bold mb-4 text-gray-800 border-b-2 border-amber-500 pb-2">طرز تهیه</h3>
                    <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed whitespace-pre-line">{{ $recipe->description }}</div>
                </div>
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

                <!-- بخش امتیازات (داینامیک) -->
                <div class="border rounded-lg p-4 mb-6">
                    <div x-show="ratingsCount > 0" class="flex items-center justify-center">
                        <div class="text-center">
                            <p class="text-4xl font-bold text-gray-800" x-text="avgRating"></p>
                            <div class="flex justify-center text-yellow-400 mt-1">
                                <x-star-rating :rating="$averageRating" class="text-xl" />
                            </div>
                            <p class="text-sm text-gray-500 mt-2">از <span x-text="ratingsCount"></span> رأی</p>
                        </div>
                    </div>
                    <div x-show="ratingsCount == 0" x-cloak>
                        <p class="text-center text-gray-500 py-4">هنوز امتیازی برای این دستور ثبت نشده است.</p>
                    </div>
                </div>

                {{-- فرم‌های ثبت نظر و امتیاز --}}
                @auth
                    <div class="border-t pt-6">
                        <form @submit.prevent="submitForm($event, 'rating')" action="{{ route('ratings.store', $recipe) }}" method="POST" class="mb-6">
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
                                .rating input:checked ~ label, .rating label:hover, .rating label:hover ~ label { color: #facc15; }
                            </style>
                            <button type="submit" :disabled="isLoading" class="px-4 py-2 mt-2 bg-amber-500 text-white text-sm font-semibold rounded-md hover:bg-amber-600 disabled:bg-amber-300">ثبت امتیاز</button>
                        </form>

                        <form @submit.prevent="submitForm($event, 'comment')" action="{{ route('comments.store', $recipe) }}" method="POST">
                            @csrf
                            <h4 class="text-lg font-semibold mb-2">نظر شما</h4>
                            <textarea name="body" rows="4" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500" placeholder="نظر خود را بنویسید..."></textarea>
                            <div class="mt-3">
                                <button type="submit" :disabled="isLoading" class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 disabled:bg-blue-400">ارسال نظر</button>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="text-center border-t pt-6">
                        <p class="text-gray-600">برای ثبت نظر و امتیاز، لطفاً <a href="{{ route('login') }}" class="font-bold text-amber-600 underline">وارد شوید</a>.</p>
                    </div>
                @endauth

                {{-- کانتینر برای بارگذاری مجدد لیست نظرات --}}
                <div id="comments-section">
                    @include('recipes.partials._comments_section', ['recipe' => $recipe])
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
