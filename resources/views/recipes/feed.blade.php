<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            دستورهای دنبال‌شوندگان
        </h2>
    </x-slot>

    <div dir="rtl" class="py-12"
         x-data="{
             loading: false,
             page: 1,
             hasMorePages: {{ $recipes->hasMorePages() ? 'true' : 'false' }},
             loadMore() {
                 if (this.loading || !this.hasMorePages) return;

                 this.loading = true;
                 this.page++;

                 let url = `{{ route('recipes.feed') }}?page=${this.page}`;

                 fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                     .then(response => response.json())
                     .then(data => {
                         document.getElementById('recipes-grid').insertAdjacentHTML('beforeend', data.html);
                         this.hasMorePages = data.hasMorePages;
                         this.loading = false;
                     });
             }
         }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- گرید نمایش نتایج --}}
            <div id="recipes-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @include('recipes.partials._recipe_cards', ['recipes' => $recipes])
            </div>

            {{-- پیام "نتیجه‌ای یافت نشد" --}}
            @if($recipes->isEmpty())
                <div class="col-span-full text-center py-12 bg-white rounded-lg shadow-md">
                    <p class="text-lg text-gray-500">
                        شما هنوز کسی را دنبال نمی‌کنید یا افرادی که دنبال می‌کنید، دستوری منتشر نکرده‌اند.
                    </p>
                    <a href="{{ route('recipes.index') }}" class="mt-4 inline-block text-amber-600 hover:underline">کشف دستورهای جدید</a>
                </div>
            @endif

            {{-- نشانگر بارگذاری --}}
            <div x-show="loading" class="text-center py-8 col-span-full">
                <p class="text-gray-500">در حال بارگذاری دستورهای بیشتر...</p>
            </div>

            <div x-show="hasMorePages" x-intersect:enter.full="loadMore()"></div>
        </div>
    </div>
</x-app-layout>
