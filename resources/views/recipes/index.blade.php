<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center" dir="rtl">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                @if (request('search'))
                    نتایج جستجو برای: "{{ request('search') }}"
                @else
                    دستورهای غذایی
                @endif
            </h2>
        </div>
    </x-slot>

    <div dir="rtl" class="py-12"
         x-data="{
             loading: false,
             page: 1,
             hasMorePages: {{ $recipes->hasMorePages() ? 'true' : 'false' }},
             search: '{{ request('search', '') }}',

             loadMore() {
                 if (!this.loading && this.hasMorePages) {
                     this.loading = true;
                     this.page++;

                     let url = `{{ route('recipes.index') }}?page=${this.page}`;
                     if (this.search) {
                         url += `&search=${this.search}`;
                     }

                     fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                         .then(response => response.json())
                         .then(data => {
                             document.getElementById('recipes-grid').insertAdjacentHTML('beforeend', data.html);
                             this.hasMorePages = data.hasMorePages;
                             this.loading = false;
                         });
                 }
             }
         }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- جستجو --}}
            <div class="mb-8">
                <form action="{{ route('recipes.index') }}" method="GET">
                    <input type="text" name="search" placeholder="جستجو در میان دستورهای غذایی..."
                           value="{{ request('search') }}"
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-amber-500 focus:border-amber-500">
                </form>
            </div>

            {{--  نتایج --}}
            <div id="recipes-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @include('recipes.partials._recipe_cards', ['recipes' => $recipes])
            </div>

            @if($recipes->isEmpty())
                <div class="col-span-full text-center py-12">
                    <p class="text-lg text-gray-500">
                        متاسفانه هیچ نتیجه‌ای یافت نشد.
                    </p>
                    <a href="{{ route('recipes.index') }}" class="mt-4 inline-block text-amber-600 hover:underline">بازگشت به لیست کامل دستورها</a>
                </div>
            @endif

            {{-- نشانگر بارگذاری --}}
            <div x-show="loading" class="text-center py-8">
                <p class="text-gray-500">در حال بارگذاری دستورهای بیشتر...</p>
            </div>
           // اسکرول با فراخونی تابع loadmore
            <div x-show="hasMorePages" x-intersect.full="loadMore()"></div>

        </div>
    </div>
</x-app-layout>
