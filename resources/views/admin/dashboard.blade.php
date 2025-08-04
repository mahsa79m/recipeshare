<x-admin-layout>
    <h3 class="text-3xl font-medium text-gray-700">داشبورد</h3>

    <div class="mt-4">
        <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-3">

            <a href="{{ route('admin.users.index') }}"
                class="flex items-center p-4 bg-white rounded-lg shadow-md transition-transform duration-300 hover:scale-105 hover:shadow-xl">
                <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.653-.125-1.274-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.653.125-1.274.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600">تعداد کل کاربران</p>
                    <p class="text-3xl font-bold text-gray-700">{{ $totalUsers }}</p>
                </div>
            </a>


            <a href="{{ route('admin.recipes.index') }}"
                class="flex items-center p-4 bg-white rounded-lg shadow-md transition-transform duration-300 hover:scale-105 hover:shadow-xl">
                <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h7"></path>
                    </svg>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600">تعداد کل دستورهای منتشر شده</p>
                    <p class="text-3xl font-bold text-gray-700">{{ $totalRecipes }}</p>
                </div>
            </a>


            <a href="{{ route('admin.reports.index') }}"
                class="flex items-center p-4 bg-white rounded-lg shadow-md transition-transform duration-300 hover:scale-105 hover:shadow-xl">
                <div class="p-3 mr-4 text-red-500 bg-red-100 rounded-full">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600">گزارش‌های در حال انتظار</p>
                    <p class="text-3xl font-bold text-red-500">{{ $pendingReports }}</p>
                </div>
            </a>
        </div>
    </div>


    <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="p-6 bg-white rounded-lg shadow">
            <h4 class="text-xl font-semibold text-gray-700 mb-4">روند ثبت‌نام کاربران (۷ روز گذشته)</h4>
            <canvas id="userGrowthChart"></canvas>
        </div>
        <div class="p-6 bg-white rounded-lg shadow">
            <div class="flex justify-between items-center mb-4">
                <h4 class="text-xl font-semibold text-gray-700">محبوب‌ترین دستورها</h4>
            </div>
            <div class="space-y-4">
                @forelse ($popularRecipes as $recipe)
                    <div class="flex items-center justify-between">
                        <div>
                            <a href="{{ route('recipes.show', $recipe) }}" target="_blank"
                                class="font-semibold text-gray-800 hover:text-amber-600 hover:underline">
                                {{ Str::limit($recipe->title, 30) }}
                            </a>
                            <p class="text-sm text-gray-500">توسط: {{ $recipe->user->name }}</p>
                        </div>
                        <div class="flex items-center text-yellow-500">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                </path>
                            </svg>
                            <span class="ml-1 font-bold">{{ number_format($recipe->ratings_avg_rating, 1) }}</span>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">هنوز هیچ دستوری امتیاز دریافت نکرده است.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- فعال‌ترین کاربران -->
        <div class="p-6 bg-white rounded-lg shadow">
            <div class="flex justify-between items-center mb-4">
                <h4 class="text-xl font-semibold text-gray-700">فعال‌ترین کاربران</h4>
            </div>
            <div class="space-y-4">
                @forelse ($activeUsers as $user)
                    <div class="flex items-center justify-between">
                        <a href="{{ route('users.show', $user) }}" target="_blank"
                            class="font-semibold text-gray-800 hover:text-amber-600 hover:underline">
                            {{ $user->name }}
                        </a>
                        <span class="text-sm text-gray-500">{{ $user->recipes_count }} دستور پخت</span>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">هنوز هیچ کاربری دستوری منتشر نکرده است.</p>
                @endforelse
            </div>
        </div>

        <!-- ستون جدیدترین کاربران -->
        <div class="p-6 bg-white rounded-lg shadow">
            <div class="flex justify-between items-center mb-4">
                <h4 class="text-xl font-semibold text-gray-700">آخرین ثبت‌نام‌ها</h4>
                <a href="{{ route('admin.users.index') }}"
                    class="text-sm font-semibold text-amber-600 hover:underline">مشاهده همه</a>
            </div>
            <div class="space-y-4">
                @forelse ($latestUsers as $user)
                    <div class="flex items-center justify-between">
                        <a href="{{ route('users.show', $user) }}" target="_blank"
                            class="font-semibold text-gray-800 hover:text-amber-600 hover:underline">
                            {{ $user->name }}
                        </a>
                        <span class="text-sm text-gray-500">{{ verta($user->created_at)->formatDifference() }}</span>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">اخیراً کاربری ثبت‌نام نکرده است.</p>
                @endforelse
            </div>
        </div>

        <!-- ستون محبوب‌ترین دسته‌بندی‌ها -->
        <div class="p-6 bg-white rounded-lg shadow">
            <div class="flex justify-between items-center mb-4">
                <h4 class="text-xl font-semibold text-gray-700">محبوب‌ترین دسته‌بندی‌ها</h4>
                <a href="{{ route('admin.categories.index') }}"
                    class="text-sm font-semibold text-amber-600 hover:underline">مشاهده همه</a>
            </div>
            <div class="space-y-4">
                @forelse ($popularCategories as $category)
                    <div class="flex items-center justify-between">
                        <a href="{{ route('categories.show', $category) }}" target="_blank"
                            class="font-semibold text-gray-800 hover:text-amber-600 hover:underline">
                            {{ $category->name }}
                        </a>
                        <span class="text-sm text-gray-500">{{ $category->recipes_count }} دستور پخت</span>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">هنوز هیچ دسته‌بندی‌ای وجود ندارد.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{--   نمودار --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('userGrowthChart');
            if (ctx) {
                const chartLabels = @json($chartLabels);
                const chartData = @json($chartData);

                if (chartLabels.length > 0) {
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: chartLabels,
                            datasets: [{
                                label: 'کاربران جدید',
                                data: chartData,
                                backgroundColor: 'rgba(251, 146, 60, 0.2)',
                                borderColor: 'rgba(251, 146, 60, 1)',
                                borderWidth: 2,
                                tension: 0.4,
                                fill: true,
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        stepSize: 1,
                                        callback: function(value) {
                                            if (value % 1 === 0) {
                                                return value;
                                            }
                                        }
                                    }
                                }
                            },
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top'
                                }
                            }
                        }
                    });
                } else {
                    ctx.parentElement.innerHTML =
                        '<p class="text-center text-gray-500 py-8">داده‌ای برای نمایش نمودار وجود ندارد.</p>';
                }
            }
        });
    </script>
</x-admin-layout>
