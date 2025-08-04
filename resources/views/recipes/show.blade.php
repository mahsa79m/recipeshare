{{-- resources/views/recipes/show.blade.php --}}
<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                دستور غذا
            </h2>

            <div class="flex items-center gap-x-4">

                {{-- موبایل --}}
                <a href="{{ route('recipes.create') }}"
                    class="inline-flex sm:hidden items-center px-4 py-2 bg-amber-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-amber-600 active:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    + افزودن دستور غذا
                </a>

                <button onclick="window.history.back();"
                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">
                    بازگشت
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </button>

            </div>
        </div>
    </x-slot>

    <div class="bg-slate-50" dir="rtl" x-data="{
        menuOpen: false,
        activeForm: null, // 'rating', 'comment', or null
        openReplyForm: null,
        successMessage: '',
        errorMessage: '',
        isLoading: false,
        avgRating: {{ (float) ($averageRating ?? 0) }},
        ratingsCount: {{ $ratingsCount ?? 0 }},
        reportModalOpen: false,

        submitForm(event, type) {
            event.preventDefault();
            this.isLoading = true;
            this.successMessage = '';
            this.errorMessage = '';
            let form = event.target;
            let formData = new FormData(form);

            fetch(form.action, {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: formData
                })
                .then(response => response.json().then(data => ({ status: response.status, body: data })))
                .then(({ status, body }) => {
                    if (status >= 200 && status < 300) {
                        this.successMessage = body.message;
                        if (type === 'rating') {
                            this.avgRating = body.averageRating;
                            this.ratingsCount = body.ratingsCount;
                            this.activeForm = null;
                            form.reset();
                        } else if (type === 'comment') {
                            document.getElementById('comments-section').innerHTML = body.commentsHtml;
                            this.activeForm = null;
                            form.reset();
                            this.openReplyForm = null;
                        } else if (type === 'report') {
                            this.reportModalOpen = false;
                            form.reset();
                        }
                        setTimeout(() => this.successMessage = '', 4000);
                    } else {
                        this.errorMessage = body.message || 'خطایی رخ داد. لطفا دوباره تلاش کنید.';
                        setTimeout(() => this.errorMessage = '', 4000);
                    }
                })
                .catch(error => {
                    this.errorMessage = 'خطای شبکه. لطفا اتصال اینترنت خود را بررسی کنید.';
                    setTimeout(() => this.errorMessage = '', 4000);
                    console.error('Error:', error);
                })
                .finally(() => this.isLoading = false);
        }
    }">

        <div x-show="successMessage || errorMessage" x-cloak x-transition
            class="fixed top-20 left-1/2 -translate-x-1/2 px-6 py-3 text-white rounded-full shadow-lg z-50"
            :class="successMessage ? 'bg-green-500' : 'bg-red-500'">
            <p x-text="successMessage || errorMessage"></p>
        </div>

        <div class="container mx-auto max-w-4xl py-12 px-4 space-y-8">

            <!--  دستور پخت -->
            <div class="bg-white p-6 rounded-2xl shadow-lg">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4 text-center">{{ $recipe->title }}</h1>

                <!-- امتیاز -->
                <div class="flex items-center justify-center space-x-2 space-x-reverse mb-6">
                    <span class="text-2xl font-bold text-yellow-500" x-text="avgRating.toFixed(1)"></span>
                    <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                        </path>
                    </svg>
                    <span class="text-gray-500 text-sm">(از <span x-text="ratingsCount"></span> رأی)</span>
                </div>

                @if ($recipe->image_path)
                    <div class="mb-8">
                        <div class="aspect-w-16 aspect-h-9 w-full overflow-hidden rounded-2xl shadow-lg">
                            <img src="{{ asset('storage/' . $recipe->image_path) }}" alt="{{ $recipe->title }}"
                                class="w-full h-full object-cover">
                        </div>
                    </div>
                @endif

                <!-- نویسنده و منو  -->
                <div class="flex justify-between items-center mb-8">
                    <a href="{{ route('users.show', $recipe->user) }}" class="flex items-center">
                        <img class="h-12 w-12 rounded-full object-cover"
                            src="{{ $recipe->user->profile_image_path ? asset('storage/' . $recipe->user->profile_image_path) : 'https://ui-avatars.com/api/?name=' . urlencode($recipe->user->name) }}"
                            alt="{{ $recipe->user->name }}">
                        <div class="mr-4">
                            <h4 class="font-bold text-gray-800 hover:text-amber-600">{{ $recipe->user->name }}</h4>
                            <p class="text-sm text-gray-500">{{ $recipe->created_at->diffForHumans() }}</p>
                        </div>
                    </a>

                    <!-- منو سه نقطه -->
                    @auth
                        <div class="relative">
                            <button @click="menuOpen = !menuOpen"
                                class="text-gray-500 hover:text-gray-700 focus:outline-none p-2 rounded-full">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                                    </path>
                                </svg>
                            </button>
                            <div x-show="menuOpen" @click.away="menuOpen = false" x-cloak
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="origin-top-left absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-20">
                                <div class="py-1">
                                    @can('update', $recipe)
                                        <a href="{{ route('recipes.edit', $recipe) }}"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">ویرایش</a>
                                    @endcan
                                    @can('delete', $recipe)
                                        <form method="POST" action="{{ route('recipes.destroy', $recipe) }}"
                                            onsubmit="return confirm('آیا از حذف این دستور غذا مطمئن هستید؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-full text-right block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">حذف</button>
                                        </form>
                                    @endcan
                                    @if (Auth::id() !== $recipe->user->id)
                                        <button @click="reportModalOpen = true; menuOpen = false"
                                            class="w-full text-right block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">گزارش
                                            تخلف</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endauth
                </div>

                <div class="mb-8">
                    <h3 class="text-2xl font-bold mb-4 text-gray-800 border-b-2 border-amber-500 pb-2">مواد لازم</h3>
                    @php
                        $ingredientsList = json_decode($recipe->ingredients, true);
                        if (json_last_error() !== JSON_ERROR_NONE) {
                            $ingredientsList = null;
                        }
                    @endphp
                    @if (is_array($ingredientsList))
                        <ul class="list-disc list-inside space-y-2 prose prose-lg max-w-none text-gray-700">
                            @foreach ($ingredientsList as $item)
                                <li><strong>{{ $item['name'] ?? '' }}</strong>: {{ $item['quantity'] ?? '' }}
                                    {{ $item['unit'] ?? '' }}</li>
                            @endforeach
                        </ul>
                    @else
                        <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed whitespace-pre-line">
                            {{ $recipe->ingredients }}</div>
                    @endif
                </div>

                <div>
                    <h3 class="text-2xl font-bold mb-4 text-gray-800 border-b-2 border-amber-500 pb-2">طرز تهیه</h3>
                    <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed whitespace-pre-line">
                        {{ $recipe->description }}</div>
                </div>
            </div>

            <!-- نظر و امتیاز -->
            <div class="bg-white p-6 rounded-2xl shadow-lg">
                <h3 class="text-2xl font-bold mb-6 text-gray-800">امتیاز و نظرات</h3>

                @auth
                    <!-- بازکردن فرمها  -->
                    <div class="flex space-x-4 space-x-reverse mb-6">
                        <button @click="activeForm = (activeForm === 'rating' ? null : 'rating')"
                            :class="activeForm === 'rating' ? 'bg-amber-600' : 'bg-amber-500'"
                            class="text-white font-bold py-2 px-4 rounded-lg transition duration-300 hover:bg-amber-600">
                            ثبت یا ویرایش امتیاز
                        </button>
                        <button @click="activeForm = (activeForm === 'comment' ? null : 'comment')"
                            :class="activeForm === 'comment' ? 'bg-blue-700' : 'bg-blue-600'"
                            class="text-white font-bold py-2 px-4 rounded-lg transition duration-300 hover:bg-blue-700">
                            نوشتن نظر
                        </button>
                    </div>

                    <!-- فرم ثبت امتیاز  -->
                    <div x-show="activeForm === 'rating'" x-cloak x-transition class="border-t pt-6 mb-6">
                        <form @submit.prevent="submitForm($event, 'rating')" action="{{ route('ratings.store', $recipe) }}"
                            method="POST">
                            @csrf
                            <h4 class="text-lg font-semibold mb-2">امتیاز شما</h4>
                            <div class="rating flex flex-row-reverse justify-end text-4xl">
                                <input type="radio" id="star5" name="rating" value="5"
                                    class="hidden" /><label for="star5"
                                    class="cursor-pointer text-gray-300 transition-colors">★</label>
                                <input type="radio" id="star4" name="rating" value="4"
                                    class="hidden" /><label for="star4"
                                    class="cursor-pointer text-gray-300 transition-colors">★</label>
                                <input type="radio" id="star3" name="rating" value="3"
                                    class="hidden" /><label for="star3"
                                    class="cursor-pointer text-gray-300 transition-colors">★</label>
                                <input type="radio" id="star2" name="rating" value="2"
                                    class="hidden" /><label for="star2"
                                    class="cursor-pointer text-gray-300 transition-colors">★</label>
                                <input type="radio" id="star1" name="rating" value="1"
                                    class="hidden" /><label for="star1"
                                    class="cursor-pointer text-gray-300 transition-colors">★</label>
                            </div>
                            <style>
                                .rating input:checked~label,
                                .rating label:hover,
                                .rating label:hover~label {
                                    color: #facc15;
                                }
                            </style>
                            <button type="submit" :disabled="isLoading"
                                class="px-4 py-2 mt-2 bg-green-500 text-white text-sm font-semibold rounded-md hover:bg-green-600 disabled:bg-green-300">ثبت
                                امتیاز</button>
                        </form>
                    </div>

                    <!-- فرم ثبت نظر  -->
                    <div x-show="activeForm === 'comment'" x-cloak x-transition class="border-t pt-6 mb-6">
                        <form @submit.prevent="submitForm($event, 'comment')"
                            action="{{ route('comments.store', $recipe) }}" method="POST">
                            @csrf
                            <h4 class="text-lg font-semibold mb-2">نظر خود را بنویسید</h4>
                            <textarea name="body" rows="4"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500"
                                placeholder="نظر شما..."></textarea>
                            <div class="mt-3">
                                <button type="submit" :disabled="isLoading"
                                    class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 disabled:bg-blue-400">ارسال
                                    نظر</button>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="text-center border rounded-lg p-6 mb-6">
                        <p class="text-gray-600">برای ثبت نظر و امتیاز، لطفاً <a href="{{ route('login') }}"
                                class="font-bold text-amber-600 underline">وارد شوید</a>.</p>
                    </div>
                @endauth

                <!--  نظرات -->
                <div id="comments-section" class="border-t pt-6">
                    @include('recipes.partials._comments_section', ['recipe' => $recipe])
                </div>
            </div>
        </div>

        <!-- گزارش تخلف -->
        <div x-show="reportModalOpen" x-cloak x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" @keydown.escape.window="reportModalOpen = false"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-75">
            <div @click.away="reportModalOpen = false" x-show="reportModalOpen" x-transition
                class="relative bg-white rounded-lg shadow-xl max-w-lg w-full">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">گزارش تخلف</h3>
                    <form @submit.prevent="submitForm($event, 'report')"
                        action="{{ route('recipes.report', $recipe->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="recipe_id" value="{{ $recipe->id }}">
                        <div class="space-y-4">
                            <div>
                                <label for="reason" class="block text-sm font-medium text-gray-700">دلیل
                                    گزارش:</label>
                                <select name="reason" id="reason" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500">
                                    <option value="spam">اسپم یا تبلیغات</option>
                                    <option value="inappropriate">محتوای نامناسب</option>
                                    <option value="copyright">نقض کپی‌رایت</option>
                                    <option value="inappropriate">دستور پخت ناقص</option>
                                    <option value="other">سایر موارد</option>
                                </select>
                            </div>
                            <div>
                                <label for="details" class="block text-sm font-medium text-gray-700">توضیحات
                                    (اختیاری):</label>
                                <textarea name="details" id="details" rows="3"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500"></textarea>
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end space-x-2 space-x-reverse">
                            <button type="button" @click="reportModalOpen = false"
                                class="px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300">لغو</button>
                            <button type="submit" :disabled="isLoading"
                                class="px-4 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 disabled:bg-red-400 flex items-center justify-center w-32">
                                <span x-show="isLoading"
                                    class="animate-spin inline-block w-5 h-5 border-2 border-white rounded-full border-t-transparent"></span>
                                <span x-show="!isLoading">ارسال گزارش</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
