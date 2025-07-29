<x-admin-layout>
    <h3 class="text-3xl font-medium text-gray-700">داشبورد</h3>

    {{-- کارت‌های آمار کلی --}}
    <div class="mt-4">
        <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-3">
            {{-- Card for Total Users --}}
            <div class="flex items-center p-4 bg-white rounded-lg shadow-md">
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600">تعداد کل کاربران</p>
                    <p class="text-3xl font-bold text-gray-700">{{ $totalUsers }}</p>
                </div>
            </div>
            {{-- Card for Published Recipes --}}
            <div class="flex items-center p-4 bg-white rounded-lg shadow-md">
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600">دستورهای منتشر شده</p>
                    <p class="text-3xl font-bold text-gray-700">{{ $totalRecipes }}</p>
                </div>
            </div>
            {{-- Card for Pending Recipes --}}
            <div class="flex items-center p-4 bg-white rounded-lg shadow-md">
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600">در انتظار تایید</p>
                    <p class="text-3xl font-bold text-amber-500">{{ $pendingRecipes }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- چیدمان دو ستونی برای نمودار و لیست محبوب‌ترین‌ها --}}
    <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="p-6 bg-white rounded-lg shadow">
            <h4 class="text-xl font-semibold text-gray-700 mb-4">روند ثبت‌نام کاربران (۷ روز گذشته)</h4>
            <canvas id="userGrowthChart"></canvas>
        </div>
        <div class="p-6 bg-white rounded-lg shadow">
            <h4 class="text-xl font-semibold text-gray-700 mb-4">محبوب‌ترین دستورها (بر اساس امتیاز)</h4>
            <div class="space-y-4">
                @forelse ($popularRecipes as $recipe)
                    <div class="flex items-center justify-between">
                        <div>
                            <a href="{{ route('recipes.show', $recipe) }}" target="_blank" class="font-semibold text-gray-800 hover:text-amber-600 hover:underline">
                                {{ Str::limit($recipe->title, 30) }}
                            </a>
                            <p class="text-sm text-gray-500">توسط: {{ $recipe->user->name }}</p>
                        </div>
                        <div class="flex items-center text-yellow-500">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <span class="ml-1 font-bold">{{ number_format($recipe->ratings_avg_rating, 1) }}</span>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">هنوز هیچ دستوری امتیاز دریافت نکرده است.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- چیدمان سه ستونی برای کاربران و دسته‌بندی‌ها --}}
    <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- ستون فعال‌ترین کاربران -->
        <div class="p-6 bg-white rounded-lg shadow">
            <h4 class="text-xl font-semibold text-gray-700 mb-4">فعال‌ترین کاربران</h4>
            <div class="space-y-4">
                @forelse ($activeUsers as $user)
                    <div class="flex items-center justify-between">
                        <a href="{{ route('users.show', $user) }}" target="_blank" class="font-semibold text-gray-800 hover:text-amber-600 hover:underline">
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
            <h4 class="text-xl font-semibold text-gray-700 mb-4">آخرین ثبت‌نام‌ها</h4>
            <div class="space-y-4">
                @forelse ($latestUsers as $user)
                    <div class="flex items-center justify-between">
                        <a href="{{ route('users.show', $user) }}" target="_blank" class="font-semibold text-gray-800 hover:text-amber-600 hover:underline">
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
            <h4 class="text-xl font-semibold text-gray-700 mb-4">محبوب‌ترین دسته‌بندی‌ها</h4>
            <div class="space-y-4">
                @forelse ($popularCategories as $category)
                    <div class="flex items-center justify-between">
                        <a href="{{ route('categories.show', $category) }}" target="_blank" class="font-semibold text-gray-800 hover:text-amber-600 hover:underline">
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

    {{-- فراخوانی کتابخانه و اسکریپت نمودار --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('userGrowthChart');
        const chartLabels = {!! $chartLabels->toJson() !!};
        const chartData = {!! $chartData->toJson() !!};

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
                    scales: { y: { beginAtZero: true, ticks: { stepSize: 1, callback: function(value) {if (value % 1 === 0) {return value;}} } } },
                    responsive: true,
                    plugins: { legend: { position: 'top' } }
                }
            });
        }
    </script>
</x-admin-layout>
